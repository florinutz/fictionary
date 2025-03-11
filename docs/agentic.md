# Narrative World Bible Generation: Multi-Agent LangGraph Architecture

## Overview

This document outlines a high-level design for a LangGraph-based multi-agent system that transforms unstructured input into a comprehensive, rich, and imaginative narrative world bible. The system leverages specialized agents working in concert to analyze, extract, create, and refine elements of a fictional universe, resulting in a cohesive world bible that can serve as the foundation for storytelling, game development, or other creative endeavors.

## System Architecture

The architecture employs a **Hierarchical Supervisor** pattern with specialized agents organized into functional teams. This design balances autonomy and coordination, allowing for both specialized expertise and cohesive integration of world elements.

```
                           ┌─────────────────────┐
                           │  Master Supervisor  │
                           └──────────┬──────────┘
                                      │
                 ┌────────────────────┼────────────────────┐
                 │                    │                    │
        ┌────────▼─────────┐ ┌────────▼─────────┐ ┌────────▼─────────┐
        │  Analysis Team   │ │  Creation Team   │ │ Integration Team │
        │    Supervisor    │ │    Supervisor    │ │    Supervisor    │
        └────────┬─────────┘ └────────┬─────────┘ └────────┬─────────┘
                 │                    │                    │
        ┌────────┼─────────┐ ┌────────┼─────────┐ ┌────────┼─────────┐
        │        │         │ │        │         │ │        │         │
┌───────▼─┐ ┌────▼───┐ ┌──▼───┐ ┌────▼───┐ ┌───▼────┐ ┌───▼────┐ ┌──▼─────┐
│ Content │ │ Genre  │ │ Theme │ │Character│ │ Setting│ │Narrative│ │Coherence│
│ Analyzer│ │Detector│ │Extractor│ │ Creator │ │ Creator│ │Assembler│ │ Checker │
└─────────┘ └────────┘ └───────┘ └─────────┘ └────────┘ └─────────┘ └─────────┘
```

### Agent Teams and Roles

The system is organized into three primary teams, each with a supervisor agent and specialized worker agents:

#### 1. Analysis Team

Responsible for processing and understanding the unstructured input data:

- **Content Analyzer Agent**: Processes raw input, identifies key elements, and prepares data for further analysis
- **Genre Detector Agent**: Determines the genre, tone, and style of the content
- **Theme Extractor Agent**: Identifies core themes, motifs, and philosophical underpinnings

#### 2. Creation Team

Responsible for generating the core elements of the world bible:

- **Character Creator Agent**: Designs and develops characters with rich backgrounds, motivations, and relationships
- **Setting Creator Agent**: Crafts locations, environments, and their physical and cultural characteristics
- **World Rules Creator Agent**: Establishes the laws, systems, and mechanics that govern the fictional universe
- **Timeline Creator Agent**: Develops historical events and chronologies that shape the world

#### 3. Integration Team

Responsible for assembling, refining, and ensuring the quality of the final world bible:

- **Narrative Assembler Agent**: Combines all elements into a cohesive narrative structure
- **Coherence Checker Agent**: Identifies and resolves inconsistencies and contradictions
- **Enrichment Agent**: Adds depth, nuance, and imaginative details to enhance the world
- **Format Specialist Agent**: Structures the final output according to world bible conventions

### Supervisor Hierarchy

The system employs a three-level hierarchy:

1. **Master Supervisor**: Orchestrates the overall workflow, delegates tasks to team supervisors, and manages the high-level process
2. **Team Supervisors**: Coordinate specialized agents within their teams, ensure quality of team outputs, and communicate with the Master Supervisor
3. **Specialized Agents**: Focus on specific tasks within their domain of expertise

## Workflow Process

The world bible generation process follows these key stages:

### 1. Input Processing and Analysis

```
┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│ Unstructured│     │  Document   │     │   Content   │
│    Input    │────▶│ Processing  │────▶│  Analysis   │
└─────────────┘     └─────────────┘     └──────┬──────┘
                                               │
                                               ▼
                                        ┌─────────────┐
                                        │    Genre    │
                                        │ & Thematic  │
                                        │  Analysis   │
                                        └─────────────┘
```

1. **Input Ingestion**: The system accepts unstructured text input (stories, notes, descriptions, etc.)
2. **Document Processing**: Content is chunked, embedded, and prepared for analysis
3. **Content Analysis**: The Analysis Team extracts key information, identifies patterns, and determines the nature of the content
4. **Genre and Theme Detection**: The system identifies the genre, tone, style, and core themes

### 2. Element Creation and Development

```
                    ┌─────────────┐
                    │  Creation   │
                    │ Coordinator │
                    └──────┬──────┘
                           │
         ┌────────────────┼────────────────┐
         │                │                │
┌────────▼─────┐  ┌───────▼────────┐  ┌───▼────────────┐
│  Character   │  │    Setting     │  │   World Rules   │
│  Generation  │  │   Generation   │  │   Generation    │
└──────┬───────┘  └───────┬────────┘  └────────┬───────┘
       │                  │                     │
       └──────────────────┼─────────────────────┘
                          │
                          ▼
                   ┌─────────────┐
                   │  Timeline   │
                   │ Generation  │
                   └─────────────┘
```

1. **Parallel Element Creation**: The Creation Team works in parallel to generate:
   - Characters with detailed profiles
   - Settings and locations with rich descriptions
   - World rules, systems, and mechanics
   - Historical timeline and events

2. **Element Enrichment**: Each element is enhanced with details, connections, and nuance

### 3. Integration and Refinement

```
┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│   Element   │     │ Consistency │     │ Narrative   │
│ Integration │────▶│   Checking  │────▶│ Enhancement │
└─────────────┘     └─────────────┘     └──────┬──────┘
                                               │
                                               ▼
                                        ┌─────────────┐
                                        │    Final    │
                                        │ Formatting  │
                                        └─────────────┘
```

1. **Element Integration**: The Integration Team combines all created elements into a cohesive whole
2. **Consistency Checking**: The system identifies and resolves contradictions and inconsistencies
3. **Narrative Enhancement**: The world bible is enriched with additional details and connections
4. **Final Formatting**: The world bible is structured according to standard conventions

### 4. Human-in-the-Loop Refinement (Optional)

```
┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│   Initial   │     │    Human    │     │  Revised    │
│ World Bible │────▶│   Feedback  │────▶│ World Bible │
└─────────────┘     └─────────────┘     └─────────────┘
```

1. **Human Review**: Users can review the generated world bible
2. **Feedback Integration**: The system incorporates human feedback
3. **Iterative Refinement**: The world bible is revised based on feedback

## Technical Implementation

### State Schema

The system maintains a comprehensive state that tracks the progress of the world bible generation:

```typescript
export const WorldBibleState = z.object({
  // Input and processing state
  rawContent: z.array(z.object({
    content: z.string(),
    metadata: z.record(z.string()).optional(),
  })),
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

  // World elements
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
```

### Agent Implementation

Each agent in the system is implemented as a LangGraph node with:

1. **Specialized Prompts**: Tailored to the agent's specific role and expertise
2. **Tool Access**: Access to relevant tools for their domain
3. **Memory Management**: Appropriate state access and update capabilities

Example implementation of a specialized agent:

```typescript
const characterCreatorAgent = async (
  state: WorldBibleStateType,
  config: RunnableConfig
): Promise<WorldBibleStateType> => {
  const { contentAnalysis, processedDocuments } = state;

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
    ["system", `You are an expert character creator specializing in ${contentAnalysis?.genre || "fiction"}.
    Create rich, nuanced characters with depth, motivations, and relationships.
    The content is set in ${contentAnalysis?.setting || "an unknown setting"} with themes of ${contentAnalysis?.mainThemes?.join(", ") || "various themes"}.
    Extract existing characters from the text and enhance them with additional details.
    For any underdeveloped characters, expand their profiles with imaginative but fitting details.
    If the cast of characters seems incomplete, create additional characters that would enrich the world.`],
    ["human", "Here are some relevant passages: {context}\n\nCreate a comprehensive set of characters for this world."],
  ]);

  const llm = new ChatOpenAI({
    temperature: 0.7, // Higher temperature for creative character development
    modelName: "gpt-4",
  });

  const characterSchema = z.object({
    characters: z.array(z.object({
      name: z.string().describe("The character's name"),
      description: z.string().describe("Physical description and personality"),
      background: z.string().describe("Character's history and background"),
      motivations: z.string().describe("Character's goals and motivations"),
      relationships: z.array(z.object({
        character: z.string().describe("Name of the related character"),
        relationship: z.string().describe("Description of the relationship"),
      })).describe("Character's relationships with other characters"),
    })).describe("List of all characters for this world"),
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
    currentTask: "create_settings",
  };
};
```

### Graph Definition

The workflow is defined as a LangGraph using the Functional API:

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

  // Add team supervisor nodes
  graph.addNode("masterSupervisor", masterSupervisorAgent);
  graph.addNode("analysisTeamSupervisor", analysisTeamSupervisorAgent);
  graph.addNode("creationTeamSupervisor", creationTeamSupervisorAgent);
  graph.addNode("integrationTeamSupervisor", integrationTeamSupervisorAgent);

  // Add specialized agent nodes
  graph.addNode("contentAnalyzer", contentAnalyzerAgent);
  graph.addNode("genreDetector", genreDetectorAgent);
  graph.addNode("themeExtractor", themeExtractorAgent);
  graph.addNode("characterCreator", characterCreatorAgent);
  graph.addNode("settingCreator", settingCreatorAgent);
  graph.addNode("worldRulesCreator", worldRulesCreatorAgent);
  graph.addNode("timelineCreator", timelineCreatorAgent);
  graph.addNode("narrativeAssembler", narrativeAssemblerAgent);
  graph.addNode("coherenceChecker", coherenceCheckerAgent);
  graph.addNode("enrichmentAgent", enrichmentAgent);
  graph.addNode("formatSpecialist", formatSpecialistAgent);

  // Define the edges of the graph
  graph.addEdge("__start__", "masterSupervisor");

  // Master supervisor to team supervisors
  graph.addConditionalEdges(
    "masterSupervisor",
    (state) => state.currentTask,
    {
      analyze_content: "analysisTeamSupervisor",
      create_elements: "creationTeamSupervisor",
      integrate_elements: "integrationTeamSupervisor",
      complete: "__end__",
    }
  );

  // Analysis team supervisor to specialized agents
  graph.addConditionalEdges(
    "analysisTeamSupervisor",
    (state) => state.currentTask,
    {
      process_content: "contentAnalyzer",
      detect_genre: "genreDetector",
      extract_themes: "themeExtractor",
      analysis_complete: "masterSupervisor",
    }
  );

  // Creation team supervisor to specialized agents
  graph.addConditionalEdges(
    "creationTeamSupervisor",
    (state) => state.currentTask,
    {
      create_characters: "characterCreator",
      create_settings: "settingCreator",
      create_world_rules: "worldRulesCreator",
      create_timeline: "timelineCreator",
      creation_complete: "masterSupervisor",
    }
  );

  // Integration team supervisor to specialized agents
  graph.addConditionalEdges(
    "integrationTeamSupervisor",
    (state) => state.currentTask,
    {
      assemble_narrative: "narrativeAssembler",
      check_coherence: "coherenceChecker",
      enrich_content: "enrichmentAgent",
      format_bible: "formatSpecialist",
      integration_complete: "masterSupervisor",
    }
  );

  // Specialized agent return paths
  graph.addEdge("contentAnalyzer", "analysisTeamSupervisor");
  graph.addEdge("genreDetector", "analysisTeamSupervisor");
  graph.addEdge("themeExtractor", "analysisTeamSupervisor");
  graph.addEdge("characterCreator", "creationTeamSupervisor");
  graph.addEdge("settingCreator", "creationTeamSupervisor");
  graph.addEdge("worldRulesCreator", "creationTeamSupervisor");
  graph.addEdge("timelineCreator", "creationTeamSupervisor");
  graph.addEdge("narrativeAssembler", "integrationTeamSupervisor");
  graph.addEdge("coherenceChecker", "integrationTeamSupervisor");
  graph.addEdge("enrichmentAgent", "integrationTeamSupervisor");
  graph.addEdge("formatSpecialist", "integrationTeamSupervisor");

  // Compile the graph
  return graph.compile();
};
```

## Advanced Features

### 1. Reflection and Self-Improvement

The system incorporates reflection mechanisms to improve the quality of the world bible:

```typescript
const reflectionAgent = async (
  state: WorldBibleStateType,
  config: RunnableConfig
): Promise<WorldBibleStateType> => {
  const { worldBible, contentAnalysis } = state;

  // Reflection prompt to evaluate the world bible
  const reflectionPrompt = ChatPromptTemplate.fromMessages([
    ["system", `You are an expert editor and critic specializing in narrative world bibles.
    Evaluate the quality, consistency, and completeness of this world bible.
    Identify any weaknesses, gaps, or areas for improvement.`],
    ["human", `Review this world bible for a ${contentAnalysis?.genre || "fictional"} universe:

    Title: ${worldBible?.title || "Untitled World Bible"}

    Introduction:
    ${worldBible?.introduction || "No introduction provided."}

    Characters:
    ${worldBible?.charactersSection || "No characters section provided."}

    Settings:
    ${worldBible?.settingsSection || "No settings section provided."}

    Timeline:
    ${worldBible?.timelineSection || "No timeline section provided."}

    World Rules:
    ${worldBible?.worldRulesSection || "No world rules section provided."}

    Provide a detailed critique and suggestions for improvement.`],
  ]);

  const llm = new ChatOpenAI({
    temperature: 0.3,
    modelName: "gpt-4",
  });

  const reflectionSchema = z.object({
    evaluation: z.object({
      strengths: z.array(z.string()).describe("Strengths of the world bible"),
      weaknesses: z.array(z.string()).describe("Weaknesses or gaps in the world bible"),
      suggestions: z.array(z.string()).describe("Specific suggestions for improvement"),
      overallRating: z.number().min(1).max(10).describe("Overall quality rating (1-10)"),
    }),
  });

  const structuredLLM = llm.withStructuredOutput(reflectionSchema);
  const reflection = await structuredLLM.invoke(
    await reflectionPrompt.invoke({})
  );

  return {
    ...state,
    reflection: reflection.evaluation,
    currentTask: reflection.evaluation.overallRating >= 7 ? "complete" : "revise_bible",
  };
};
```

### 2. Human-in-the-Loop Integration

The system supports human feedback and intervention at key points:

```typescript
const humanFeedbackNode = async (
  state: WorldBibleStateType,
  config: RunnableConfig
): Promise<WorldBibleStateType> => {
  // In a real implementation, this would wait for human input
  // For demonstration purposes, we'll simulate human feedback

  const humanFeedback = {
    approved: false,
    comments: "Please add more detail to the magic system and expand the character relationships.",
    specificFeedback: {
      characters: "Deepen the protagonist's motivations.",
      settings: "The capital city needs more cultural details.",
      worldRules: "The magic system needs clearer limitations.",
    },
  };

  return {
    ...state,
    humanFeedback,
    currentTask: humanFeedback.approved ? "complete" : "incorporate_feedback",
  };
};
```

### 3. Parallel Processing

The system can process multiple elements in parallel for efficiency:

```typescript
const parallelElementCreation = async (
  state: WorldBibleStateType,
  config: RunnableConfig
): Promise<WorldBibleStateType> => {
  // Create multiple elements in parallel
  const [characters, settings, worldRules] = await Promise.all([
    characterCreatorAgent(state, config),
    settingCreatorAgent(state, config),
    worldRulesCreatorAgent(state, config),
  ]);

  // Combine the results
  return {
    ...state,
    characters: characters.characters,
    settings: settings.settings,
    worldRules: worldRules.worldRules,
    currentTask: "create_timeline",
  };
};
```

## Conclusion

This multi-agent LangGraph architecture provides a comprehensive approach to generating rich, imaginative narrative world bibles from unstructured input. By leveraging specialized agents organized in a hierarchical structure, the system can process, analyze, create, and refine all elements of a fictional universe.

The design emphasizes:

1. **Specialization**: Each agent focuses on a specific aspect of world bible creation
2. **Coordination**: Supervisor agents ensure cohesive integration of elements
3. **Richness**: Multiple agents contribute diverse perspectives and expertise
4. **Flexibility**: The system can adapt to different genres, styles, and content types
5. **Quality**: Reflection and human feedback mechanisms ensure high-quality output

This architecture can be extended and customized for various creative applications, from fiction writing and game development to educational content and interactive storytelling.
