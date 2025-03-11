# Narrative World Bible Generation: Agentic Workflow Plan

## Overview

This document outlines a comprehensive plan for implementing the first agentic workflow in Fictionary: generating a narrative world bible from local unstructured data. The workflow leverages LangChain and LangGraph to create an intelligent, multi-stage process that transforms raw, unstructured content into a cohesive, structured world bible for a fictional universe.

## What is a World Bible?

A narrative world bible is a comprehensive document that contains all the essential information about a fictional universe, including:

1. **Characters**: Detailed profiles of all major and minor characters
2. **Settings**: Descriptions of locations, environments, and their characteristics
3. **History & Timeline**: Chronological events and historical background
4. **Rules & Systems**: Laws of physics, magic systems, technology, etc.
5. **Cultural Elements**: Societies, religions, languages, customs, etc.
6. **Plot Elements**: Major storylines, conflicts, and narrative arcs
7. **Themes & Tone**: Core themes, mood, and stylistic elements

## Agentic Workflow Architecture

The world bible generation workflow will use a **Tool-Calling Agent** architecture with **Reflection** capabilities, as described in [Agent Architectures](./langgraph/concepts/agentic_concepts.md). This architecture allows the agent to:

1. Make multi-step decisions
2. Use various tools to process and analyze content
3. Maintain memory across processing steps
4. Reflect on and improve its outputs

### Graph Structure

The workflow will be implemented as a LangGraph with the following high-level structure:

```
                  ┌─────────────────┐
                  │     Start       │
                  └────────┬────────┘
                           │
                           ▼
                  ┌─────────────────┐
                  │  Content Input  │
                  └────────┬────────┘
                           │
                           ▼
           ┌───────────────────────────┐
           │  Document Processing Node  │
           └───────────────┬───────────┘
                           │
                           ▼
           ┌───────────────────────────┐
           │    Content Analysis Node   │
           └───────────────┬───────────┘
                           │
                           ▼
                  ┌─────────────────┐
                  │   Router Node   │◄───┐
                  └────────┬────────┘    │
                           │             │
                           ▼             │
           ┌───────────────────────────┐ │
           │    Element Extraction     │ │
           └───────────────┬───────────┘ │
                           │             │
                           ▼             │
           ┌───────────────────────────┐ │
           │    Consistency Check      │ │
           └───────────────┬───────────┘ │
                           │             │
                           ▼             │
                  ┌─────────────────┐    │
                  │  More Elements? ├────┘
                  └────────┬────────┘
                           │ No
                           ▼
           ┌───────────────────────────┐
           │    Bible Compilation      │
           └───────────────┬───────────┘
                           │
                           ▼
           ┌───────────────────────────┐
           │    Final Refinement       │
           └───────────────┬───────────┘
                           │
                           ▼
                  ┌─────────────────┐
                  │      End        │
                  └─────────────────┘
```

## Workflow Components

### 1. State Definition

The state will track the progress of the world bible generation process, as described in [Memory](./langgraph/concepts/memory.md):

```typescript
import { z } from "zod";

// Define the state schema
export const WorldBibleState = z.object({
  // Input data
  rawContent: z.array(z.object({
    content: z.string(),
    metadata: z.record(z.string()).optional(),
  })),

  // Processing state
  processedDocuments: z.array(z.object({
    content: z.string(),
    chunks: z.array(z.string()).optional(),
    embedding: z.array(z.number()).optional(),
    metadata: z.record(z.string()).optional(),
  })).default([]),

  // Analysis results
  contentAnalysis: z.object({
    genre: z.string().optional(),
    setting: z.string().optional(),
    timeframe: z.string().optional(),
    toneAndStyle: z.string().optional(),
    mainThemes: z.array(z.string()).optional(),
  }).optional(),

  // Extracted elements
  characters: z.array(z.object({
    name: z.string(),
    description: z.string(),
    background: z.string().optional(),
    motivations: z.string().optional(),
    relationships: z.array(z.object({
      character: z.string(),
      relationship: z.string(),
    })).optional(),
  })).default([]),

  settings: z.array(z.object({
    name: z.string(),
    description: z.string(),
    significance: z.string().optional(),
  })).default([]),

  timeline: z.array(z.object({
    event: z.string(),
    timeframe: z.string().optional(),
    significance: z.string().optional(),
  })).default([]),

  worldRules: z.array(z.object({
    name: z.string(),
    description: z.string(),
    implications: z.string().optional(),
  })).default([]),

  // Output
  worldBible: z.object({
    title: z.string().optional(),
    introduction: z.string().optional(),
    charactersSection: z.string().optional(),
    settingsSection: z.string().optional(),
    timelineSection: z.string().optional(),
    worldRulesSection: z.string().optional(),
    additionalSections: z.record(z.string()).optional(),
  }).optional(),

  // Control flow
  currentTask: z.string().default("initialize"),
  errors: z.array(z.string()).default([]),
  messages: z.array(z.object({
    role: z.enum(["system", "user", "assistant", "tool"]),
    content: z.string(),
  })).default([]),
});

export type WorldBibleStateType = z.infer<typeof WorldBibleState>;
```

### 2. Node Functions

The workflow will consist of the following node functions, as described in [Low-Level API](./langgraph/concepts/low_level.md):

#### Document Processing Node

```typescript
export const processDocuments = async (
  state: WorldBibleStateType,
  config: RunnableConfig
): Promise<WorldBibleStateType> => {
  const { rawContent } = state;

  // Process each document
  const processedDocuments = await Promise.all(
    rawContent.map(async (doc) => {
      // Split document into chunks
      const textSplitter = new RecursiveCharacterTextSplitter({
        chunkSize: 1000,
        chunkOverlap: 200,
      });
      const chunks = await textSplitter.splitText(doc.content);

      // Create embeddings for retrieval
      const embeddings = new OpenAIEmbeddings();
      const embedding = await embeddings.embedQuery(doc.content);

      return {
        content: doc.content,
        chunks,
        embedding,
        metadata: doc.metadata,
      };
    })
  );

  return {
    ...state,
    processedDocuments,
    currentTask: "analyze_content",
  };
};
```

#### Content Analysis Node

```typescript
export const analyzeContent = async (
  state: WorldBibleStateType,
  config: RunnableConfig
): Promise<WorldBibleStateType> => {
  const { processedDocuments } = state;

  // Combine all document content for analysis
  const combinedContent = processedDocuments
    .map(doc => doc.content)
    .join("\n\n");

  // Use LLM to analyze content
  const analysisPrompt = ChatPromptTemplate.fromMessages([
    ["system", "You are an expert literary analyst. Analyze the following content and identify the genre, setting, timeframe, tone, style, and main themes."],
    ["human", combinedContent],
  ]);

  const llm = new ChatOpenAI({
    temperature: 0.2,
    modelName: "gpt-4",
  });

  const analysisSchema = z.object({
    genre: z.string().describe("The literary genre of the content"),
    setting: z.string().describe("The primary setting or world of the content"),
    timeframe: z.string().describe("The time period in which the content takes place"),
    toneAndStyle: z.string().describe("The tone and writing style of the content"),
    mainThemes: z.array(z.string()).describe("The main themes explored in the content"),
  });

  const structuredLLM = llm.withStructuredOutput(analysisSchema);
  const contentAnalysis = await structuredLLM.invoke(
    await analysisPrompt.invoke({})
  );

  return {
    ...state,
    contentAnalysis,
    currentTask: "extract_elements",
  };
};
```

#### Router Node

```typescript
export const routeNextTask = (
  state: WorldBibleStateType
): "extract_characters" | "extract_settings" | "extract_timeline" | "extract_world_rules" | "compile_bible" => {
  const { characters, settings, timeline, worldRules, currentTask } = state;

  // Determine which elements still need extraction
  if (characters.length === 0 || currentTask === "extract_characters") {
    return "extract_characters";
  } else if (settings.length === 0 || currentTask === "extract_settings") {
    return "extract_settings";
  } else if (timeline.length === 0 || currentTask === "extract_timeline") {
    return "extract_timeline";
  } else if (worldRules.length === 0 || currentTask === "extract_world_rules") {
    return "extract_world_rules";
  } else {
    return "compile_bible";
  }
};
```

#### Element Extraction Nodes

Multiple nodes will handle extraction of different world bible elements using the [Extraction](./langchain-core/tutorials/extraction.ipynb) pattern:

```typescript
export const extractCharacters = async (
  state: WorldBibleStateType,
  config: RunnableConfig
): Promise<WorldBibleStateType> => {
  const { processedDocuments, contentAnalysis } = state;

  // Create a vector store for retrieval
  const vectorStore = await MemoryVectorStore.fromDocuments(
    processedDocuments.map(doc => new Document({
      pageContent: doc.content,
      metadata: doc.metadata || {},
    })),
    new OpenAIEmbeddings()
  );

  // Create a retriever
  const retriever = vectorStore.asRetriever();

  // Extract characters using RAG
  const characterExtractionPrompt = ChatPromptTemplate.fromMessages([
    ["system", `You are an expert at extracting character information from text. 
    The content is from a ${contentAnalysis?.genre || "fictional"} story set in ${contentAnalysis?.setting || "an unknown setting"}.
    Extract all characters mentioned in the text, including their descriptions, backgrounds, and motivations.`],
    ["human", "Here are some relevant passages: {context}\n\nExtract all characters from these passages."],
  ]);

  const llm = new ChatOpenAI({
    temperature: 0.2,
    modelName: "gpt-4",
  });

  const characterSchema = z.object({
    characters: z.array(z.object({
      name: z.string().describe("The character's name"),
      description: z.string().describe("Physical description and personality"),
      background: z.string().optional().describe("Character's history and background"),
      motivations: z.string().optional().describe("Character's goals and motivations"),
      relationships: z.array(z.object({
        character: z.string().describe("Name of the related character"),
        relationship: z.string().describe("Description of the relationship"),
      })).optional().describe("Character's relationships with other characters"),
    })).describe("List of all characters extracted from the text"),
  });

  const structuredLLM = llm.withStructuredOutput(characterSchema);

  // Create a RAG chain
  const ragChain = RunnableSequence.from([
    {
      context: retriever.pipe(combineDocuments),
    },
    characterExtractionPrompt,
    structuredLLM,
  ]);

  const result = await ragChain.invoke({});

  return {
    ...state,
    characters: result.characters,
    currentTask: "check_consistency",
  };
};

// Similar functions for extractSettings, extractTimeline, and extractWorldRules
```

#### Consistency Check Node

```typescript
export const checkConsistency = async (
  state: WorldBibleStateType,
  config: RunnableConfig
): Promise<WorldBibleStateType> => {
  const { characters, settings, timeline, worldRules, contentAnalysis } = state;

  // Use LLM to check for consistency issues
  const consistencyPrompt = ChatPromptTemplate.fromMessages([
    ["system", "You are an expert editor reviewing a fictional world bible. Check for consistency issues between the different elements (characters, settings, timeline, world rules)."],
    ["human", `Review the following world bible elements for consistency issues:

    Genre: ${contentAnalysis?.genre || "Unknown"}
    Setting: ${contentAnalysis?.setting || "Unknown"}
    Timeframe: ${contentAnalysis?.timeframe || "Unknown"}

    Characters: ${JSON.stringify(characters, null, 2)}

    Settings: ${JSON.stringify(settings, null, 2)}

    Timeline: ${JSON.stringify(timeline, null, 2)}

    World Rules: ${JSON.stringify(worldRules, null, 2)}

    Identify any inconsistencies or contradictions between these elements.`],
  ]);

  const llm = new ChatOpenAI({
    temperature: 0.2,
    modelName: "gpt-4",
  });

  const consistencySchema = z.object({
    inconsistencies: z.array(z.object({
      type: z.string().describe("Type of inconsistency (e.g., character-timeline, setting-rules)"),
      description: z.string().describe("Description of the inconsistency"),
      suggestion: z.string().describe("Suggested resolution for the inconsistency"),
    })).describe("List of identified inconsistencies"),
    isConsistent: z.boolean().describe("Whether the world bible is generally consistent"),
  });

  const structuredLLM = llm.withStructuredOutput(consistencySchema);
  const consistencyCheck = await structuredLLM.invoke(
    await consistencyPrompt.invoke({})
  );

  // If inconsistencies are found, add them to the state
  if (!consistencyCheck.isConsistent) {
    return {
      ...state,
      errors: [...state.errors, ...consistencyCheck.inconsistencies.map(inc => inc.description)],
      currentTask: routeNextTask(state), // Continue with next element
    };
  }

  return {
    ...state,
    currentTask: routeNextTask(state), // Continue with next element
  };
};

#### Bible Compilation Node

```typescript
export const compileBible = async (
  state: WorldBibleStateType,
  config: RunnableConfig
): Promise<WorldBibleStateType> => {
  const { characters, settings, timeline, worldRules, contentAnalysis } = state;

  // Use LLM to compile the world bible
  const compilationPrompt = ChatPromptTemplate.fromMessages([
    ["system", `You are an expert world-building consultant tasked with compiling a comprehensive narrative world bible.
    Create a well-structured, professional document that organizes all the extracted information into a cohesive whole.
    The world bible should serve as a definitive reference for this fictional universe.`],
    ["human", `Compile a narrative world bible using the following elements:

    Genre: ${contentAnalysis?.genre || "Unknown"}
    Setting: ${contentAnalysis?.setting || "Unknown"}
    Timeframe: ${contentAnalysis?.timeframe || "Unknown"}
    Tone and Style: ${contentAnalysis?.toneAndStyle || "Unknown"}
    Main Themes: ${contentAnalysis?.mainThemes?.join(", ") || "Unknown"}

    Characters: ${JSON.stringify(characters, null, 2)}

    Settings: ${JSON.stringify(settings, null, 2)}

    Timeline: ${JSON.stringify(timeline, null, 2)}

    World Rules: ${JSON.stringify(worldRules, null, 2)}

    Create a complete world bible with the following sections:
    1. Title and Introduction
    2. Characters Section
    3. Settings Section
    4. Timeline Section
    5. World Rules Section
    6. Any additional sections you think would enhance the world bible`],
  ]);

  const llm = new ChatOpenAI({
    temperature: 0.3,
    modelName: "gpt-4",
  });

  const bibleSchema = z.object({
    title: z.string().describe("The title of the world bible"),
    introduction: z.string().describe("An introduction to the fictional universe"),
    charactersSection: z.string().describe("The section detailing all characters"),
    settingsSection: z.string().describe("The section detailing all settings and locations"),
    timelineSection: z.string().describe("The section detailing the timeline and history"),
    worldRulesSection: z.string().describe("The section detailing the rules and systems of the world"),
    additionalSections: z.record(z.string()).describe("Any additional sections for the world bible"),
  });

  const structuredLLM = llm.withStructuredOutput(bibleSchema);
  const worldBible = await structuredLLM.invoke(
    await compilationPrompt.invoke({})
  );

  return {
    ...state,
    worldBible,
    currentTask: "final_refinement",
  };
};

#### Final Refinement Node

```typescript
export const refineBible = async (
  state: WorldBibleStateType,
  config: RunnableConfig
): Promise<WorldBibleStateType> => {
  const { worldBible, contentAnalysis, errors } = state;

  // Use LLM to refine the world bible
  const refinementPrompt = ChatPromptTemplate.fromMessages([
    ["system", `You are an expert editor specializing in narrative world bibles and fictional universe documentation.
    Your task is to refine and improve the provided world bible, ensuring it is comprehensive, consistent, and professionally presented.
    Pay special attention to maintaining the tone and style appropriate for the genre.`],
    ["human", `Refine the following world bible:

    Title: ${worldBible?.title || "Untitled World Bible"}

    Introduction:
    ${worldBible?.introduction || "No introduction provided."}

    Characters Section:
    ${worldBible?.charactersSection || "No characters section provided."}

    Settings Section:
    ${worldBible?.settingsSection || "No settings section provided."}

    Timeline Section:
    ${worldBible?.timelineSection || "No timeline section provided."}

    World Rules Section:
    ${worldBible?.worldRulesSection || "No world rules section provided."}

    ${Object.entries(worldBible?.additionalSections || {}).map(([key, value]) => `${key}:\n${value}`).join("\n\n")}

    Genre: ${contentAnalysis?.genre || "Unknown"}
    Tone and Style: ${contentAnalysis?.toneAndStyle || "Unknown"}

    Previous Issues to Address:
    ${errors.join("\n")}

    Please refine this world bible to make it more cohesive, engaging, and professional.
    Ensure all sections flow well together and that any previous issues are addressed.`],
  ]);

  const llm = new ChatOpenAI({
    temperature: 0.3,
    modelName: "gpt-4",
  });

  const refinedBible = await llm.invoke(
    await refinementPrompt.invoke({})
  );

  // Extract the refined content
  const refinedContent = refinedBible.content;

  return {
    ...state,
    worldBible: {
      ...worldBible,
      refinedContent,
    },
    currentTask: "complete",
  };
};
```

### 3. Graph Definition

The workflow will be defined as a LangGraph using the [Functional API](./langgraph/concepts/functional_api.md):

```typescript
import { StateGraph } from "@langchain/langgraph";

export const createWorldBibleGraph = () => {
  // Create a new graph
  const graph = new StateGraph({
    channels: {
      state: {
        value: WorldBibleState,
      },
    },
  });

  // Add nodes to the graph
  graph.addNode("processDocuments", {
    invoke: processDocuments,
    input: "state",
    output: "state",
  });

  graph.addNode("analyzeContent", {
    invoke: analyzeContent,
    input: "state",
    output: "state",
  });

  graph.addNode("extractCharacters", {
    invoke: extractCharacters,
    input: "state",
    output: "state",
  });

  graph.addNode("extractSettings", {
    invoke: extractSettings,
    input: "state",
    output: "state",
  });

  graph.addNode("extractTimeline", {
    invoke: extractTimeline,
    input: "state",
    output: "state",
  });

  graph.addNode("extractWorldRules", {
    invoke: extractWorldRules,
    input: "state",
    output: "state",
  });

  graph.addNode("checkConsistency", {
    invoke: checkConsistency,
    input: "state",
    output: "state",
  });

  graph.addNode("compileBible", {
    invoke: compileBible,
    input: "state",
    output: "state",
  });

  graph.addNode("refineBible", {
    invoke: refineBible,
    input: "state",
    output: "state",
  });

  // Define the edges of the graph
  graph.addEdge("processDocuments", "analyzeContent");
  graph.addEdge("analyzeContent", "extractCharacters");

  // Add conditional edges based on the current task
  graph.addConditionalEdges(
    "extractCharacters",
    (state) => state.currentTask,
    {
      check_consistency: "checkConsistency",
    }
  );

  graph.addConditionalEdges(
    "extractSettings",
    (state) => state.currentTask,
    {
      check_consistency: "checkConsistency",
    }
  );

  graph.addConditionalEdges(
    "extractTimeline",
    (state) => state.currentTask,
    {
      check_consistency: "checkConsistency",
    }
  );

  graph.addConditionalEdges(
    "extractWorldRules",
    (state) => state.currentTask,
    {
      check_consistency: "checkConsistency",
    }
  );

  graph.addConditionalEdges(
    "checkConsistency",
    (state) => state.currentTask,
    {
      extract_characters: "extractCharacters",
      extract_settings: "extractSettings",
      extract_timeline: "extractTimeline",
      extract_world_rules: "extractWorldRules",
      compile_bible: "compileBible",
    }
  );

  graph.addEdge("compileBible", "refineBible");

  // Set the entry point
  graph.setEntryPoint("processDocuments");

  // Compile the graph
  return graph.compile();
};
```

### 4. Tools Definition

The workflow will use several tools to process and analyze content, as described in [Tool Calling](./langgraph/concepts/agentic_concepts.md#tool-calling):

```typescript
import { DynamicStructuredTool } from "@langchain/core/tools";
import { z } from "zod";

// File System Tool
export const fileSystemTool = new DynamicStructuredTool({
  name: "file_system",
  description: "Access the file system to read and write files",
  schema: z.object({
    operation: z.enum(["read", "write", "list"]),
    path: z.string().describe("The path to the file or directory"),
    content: z.string().optional().describe("The content to write to the file"),
  }),
  func: async ({ operation, path, content }) => {
    switch (operation) {
      case "read":
        try {
          const text = await Deno.readTextFile(path);
          return text;
        } catch (error) {
          return `Error reading file: ${error.message}`;
        }
      case "write":
        try {
          await Deno.writeTextFile(path, content || "");
          return `Successfully wrote to ${path}`;
        } catch (error) {
          return `Error writing file: ${error.message}`;
        }
      case "list":
        try {
          const entries = [];
          for await (const entry of Deno.readDir(path)) {
            entries.push(entry.name);
          }
          return entries.join("\n");
        } catch (error) {
          return `Error listing directory: ${error.message}`;
        }
    }
  },
});

// Text Processing Tool
export const textProcessingTool = new DynamicStructuredTool({
  name: "text_processing",
  description: "Process text using various methods",
  schema: z.object({
    operation: z.enum(["summarize", "extract_entities", "analyze_sentiment"]),
    text: z.string().describe("The text to process"),
    options: z.record(z.any()).optional().describe("Additional options for the operation"),
  }),
  func: async ({ operation, text, options }) => {
    // This would typically call other services or LLMs
    // For now, we'll just return a placeholder
    return `Processed text with operation: ${operation}`;
  },
});

// Search Tool
export const searchTool = new DynamicStructuredTool({
  name: "search",
  description: "Search for information in the processed documents",
  schema: z.object({
    query: z.string().describe("The search query"),
    filters: z.record(z.any()).optional().describe("Filters to apply to the search"),
  }),
  func: async ({ query, filters }) => {
    // This would typically search a vector database
    // For now, we'll just return a placeholder
    return `Search results for: ${query}`;
  },
});
```

## Implementation Considerations

### 1. Performance Optimization

To ensure efficient processing of large amounts of unstructured data, the implementation should consider:

- **[Caching](./langchain-core/how_to/llm_caching.mdx)**: Cache LLM responses to avoid redundant API calls
- **[Batching](./langgraph/tutorials/workflows/index.md#parallelization)**: Process multiple documents or chunks in parallel
- **[Streaming](./langgraph/concepts/streaming.md)**: Stream results for real-time feedback
- **Chunking**: Split large documents into manageable chunks for processing

### 2. Error Handling

Robust error handling is essential for a reliable workflow:

- **[Retry Logic](./langgraph/concepts/functional_api.md#retry-policy)**: Implement retry mechanisms for API calls
- **[Fallback Mechanisms](./langchain-core/how_to/fallbacks.mdx)**: Provide fallback options when operations fail
- **Graceful Degradation**: Continue processing even if some components fail
- **Comprehensive Logging**: Log all errors and warnings for debugging

### 3. Human-in-the-Loop

For complex or ambiguous content, human intervention may be necessary:

- **[Human Feedback](./langgraph/concepts/human_in_the_loop.md)**: Allow users to review and correct extracted information
- **[Breakpoints](./langgraph/concepts/breakpoints.md)**: Add breakpoints for human intervention at critical points
- **Interactive Refinement**: Enable users to refine the generated world bible

### 4. Security and Privacy

When processing user content, security and privacy are paramount:

- **[Input Validation](./langchain-core/security.md)**: Validate all inputs to prevent injection attacks
- **[Output Sanitization](./langchain-core/security.md)**: Sanitize outputs to prevent harmful content
- **Data Minimization**: Process only the necessary data
- **Secure Storage**: Store world bibles securely

## Evaluation and Improvement Strategies

### 1. Quality Metrics

To evaluate the quality of generated world bibles:

- **Consistency**: Measure the internal consistency of the world bible
- **Completeness**: Assess whether all essential elements are included
- **Coherence**: Evaluate the logical flow and organization
- **Creativity**: Assess the originality and creativity of the content

### 2. User Feedback

Collect and incorporate user feedback:

- **Satisfaction Surveys**: Gather user ratings and comments
- **Iterative Refinement**: Use feedback to improve the workflow
- **A/B Testing**: Compare different versions of the workflow

### 3. Continuous Improvement

Implement a process for continuous improvement:

- **Regular Updates**: Update the workflow as new capabilities become available
- **Performance Monitoring**: Monitor performance metrics and address bottlenecks
- **Model Upgrades**: Upgrade to newer LLM versions as they become available

## Conclusion

This comprehensive plan outlines the implementation of an agentic workflow for generating narrative world bibles from local unstructured data. By leveraging LangChain and LangGraph, the workflow can intelligently process, analyze, and transform raw content into cohesive, structured world bibles for fictional universes.

The modular design allows for flexibility and extensibility, enabling future enhancements and adaptations to different types of content and user needs. With robust error handling, performance optimization, and evaluation strategies, the workflow can deliver high-quality world bibles while continuously improving based on user feedback and technological advancements.

## References

- [LangChain Core Concepts](./langchain-core/concepts/lcel.mdx)
- [LangGraph Agent Architectures](./langgraph/concepts/agentic_concepts.md)
- [LangGraph Application Structure](./langgraph/concepts/application_structure.md)
- [Extraction Tutorial](./langchain-core/tutorials/extraction.ipynb)
- [RAG Tutorial](./langchain-core/tutorials/rag.ipynb)
- [Workflows Tutorial](./langgraph/tutorials/workflows/index.md)
