# Narrative World Bible Generation: Simplified Agentic Workflow

## Overview

This document outlines a simplified, pragmatic approach to generating comprehensive narrative world bibles using [LangGraph](langgraph/concepts/high_level.md). The system transforms unstructured input into a cohesive world bible through an iterative, dialogue-based process with clear human supervision checkpoints. This approach maintains core functionality while reducing complexity, making it ideal for MVP implementations and practical applications in storytelling, game development, or other creative endeavors.

## Core Principles

The workflow is built around four key principles:

### 1. Iterative Dialogue

The system engages in continuous dialogue with human supervisors, bundling questions to efficiently refine the plan and incorporating feedback at defined checkpoints. This ensures the final output aligns with user expectations while leveraging AI capabilities.

### 2. File-Based Memory

All state information is stored on the filesystem, including Q&A files for tracking dialogue history and output files for persistent results. This approach enables easy human intervention and inspection at any point in the process.

### 3. Simplified Roles & Clear Outputs

The workflow uses a reduced number of agent roles focused on essential functions, with clear separation of responsibilities. The final output is a comprehensive Markdown document that serves as the world bible.

### 4. Flexibility in Input

The system supports both structured responses via options and unstructured modifications at any stage, accommodating human creativity throughout the process.

## System Architecture

The architecture employs a simplified agent structure with clear responsibilities and communication paths:

```
                      ┌─────────────────────┐
                      │  Process Coordinator│
                      └──────────┬──────────┘
                                 │
            ┌────────────────────┼────────────────────┐
            │                    │                    │
   ┌────────▼─────────┐ ┌────────▼─────────┐ ┌────────▼─────────┐
   │  Content Analyst │ │  World Creator   │ │ Document Assembler│
   └─────────┬────────┘ └─────────┬────────┘ └────────┬─────────┘
             │                    │                   │
             └────────────────────┼───────────────────┘
                                  │
                         ┌────────▼─────────┐
                         │  Human Reviewer  │
                         └──────────────────┘
```

### Simplified Agent Roles

The system uses a streamlined set of agents with clear responsibilities:

#### 1. Process Coordinator

The central orchestrator that manages the overall workflow and facilitates communication:

- **Responsibilities**:
  - Guides the entire world-building process from start to finish
  - Manages transitions between workflow stages
  - Bundles questions for human feedback at key checkpoints
  - Ensures all components work together coherently
  - Makes high-level decisions about process flow
- **Tools**: Workflow management, task prioritization, feedback integration

#### 2. Content Analyst

Responsible for understanding and extracting key information from the input:

- **Input**: Raw unstructured text (stories, notes, descriptions)
- **Output**: Processed content with identified genre, themes, patterns, and key elements
- **Responsibilities**:
  - Analyzes raw input to identify core narrative elements
  - Determines genre, tone, and stylistic elements
  - Extracts themes, motifs, and symbolic elements
  - Identifies cultural and contextual references
- **Tools**: Document processing, semantic analysis, genre classification, thematic analysis

#### 3. World Creator

Responsible for generating the core elements of the world bible:

- **Input**: Analysis from Content Analyst, human feedback
- **Output**: Cohesive world elements including characters, settings, rules, and timeline
- **Responsibilities**:
  - Creates detailed character profiles with backgrounds and relationships
  - Develops settings with physical and cultural attributes
  - Establishes consistent world rules and systems
  - Constructs logical timeline of events
  - Designs social structures and cultural systems
- **Tools**: Character generation, setting creation, world-building frameworks, timeline construction

#### 4. Document Assembler

Responsible for creating the final world bible document:

- **Input**: World elements from World Creator, human feedback
- **Output**: Comprehensive, well-structured world bible document
- **Responsibilities**:
  - Integrates all world elements into a cohesive narrative structure
  - Checks for consistency and resolves contradictions
  - Enhances content with additional details and nuance
  - Formats the document for readability and navigation
  - Ensures continuity across all elements
- **Tools**: Document structuring, consistency checking, content enhancement, formatting

#### 5. Human Reviewer

The human participant who provides guidance, feedback, and creative input:

- **Responsibilities**:
  - Reviews outputs at key checkpoints
  - Answers bundled questions to guide development
  - Provides creative direction and preferences
  - Makes decisions on alternatives presented by the system
  - Has final approval authority on all content
- **Interaction Points**:
  - After initial analysis to confirm direction
  - During world element creation to shape development
  - Before final assembly to ensure alignment with vision
  - After document creation for final approval

## Iterative Dialogue Workflow

The world bible generation process follows a simplified, iterative approach with clear human checkpoints:

### 1. Initial Analysis and Planning

```
┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│ Unstructured│     │   Content   │     │   Initial   │
│    Input    │────▶│   Analysis  │────▶│  Questions  │
└─────────────┘     └─────────────┘     └──────┬──────┘
                                               │
                                               ▼
                                        ┌─────────────┐
                                        │    Human    │
                                        │   Feedback  │
                                        └─────────────┘
```

1. **Input Processing**: The Content Analyst processes unstructured text input (stories, notes, descriptions)
2. **Initial Analysis**: Key information is extracted, including genre, themes, tone, and core elements
3. **Question Bundling**: The Process Coordinator prepares a set of focused questions about unclear or ambiguous aspects
4. **First Checkpoint**: Human feedback is collected to confirm direction and fill information gaps

**File-Based Memory**:
- `input.md`: Original unstructured input stored for reference
- `analysis.json`: Structured analysis results including genre, themes, and key elements
- `questions_round1.md`: Initial questions for human review
- `feedback_round1.md`: Human responses to initial questions

**Human Interaction**:
- Humans review the initial analysis and answer bundled questions
- Feedback can be provided as direct answers or creative additions
- The system accommodates both structured (multiple choice) and unstructured (free text) responses

### 2. World Element Creation

```
┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│   Analysis  │     │    World    │     │  Element    │
│  & Feedback │────▶│   Creation  │────▶│  Questions  │
└─────────────┘     └─────────────┘     └──────┬──────┘
                                               │
                                               ▼
                                        ┌─────────────┐
                                        │    Human    │
                                        │   Feedback  │
                                        └─────────────┘
```

1. **Element Generation**: The World Creator develops core world elements based on analysis and feedback:
   - Character profiles with backgrounds and relationships
   - Settings with physical and cultural attributes
   - World rules and systems
   - Timeline of key events

2. **Element Review**: The Process Coordinator identifies areas needing clarification or creative decisions
3. **Second Checkpoint**: Human feedback is collected on world elements before final assembly

**File-Based Memory**:
- `characters.md`: Character profiles and relationships
- `settings.md`: Locations and environments
- `world_rules.md`: Systems, mechanics, and laws
- `timeline.md`: Historical events and chronology
- `questions_round2.md`: Questions about world elements
- `feedback_round2.md`: Human responses to element questions

**Human Interaction**:
- Humans review preliminary world elements and provide feedback
- The system may present alternative options for key elements
- Humans can modify any aspect of the created elements
- Feedback is incorporated directly into the world files

### 3. Document Assembly and Refinement

```
┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│    World    │     │  Document   │     │    Final    │
│   Elements  │────▶│  Assembly   │────▶│   Review    │
└─────────────┘     └─────────────┘     └──────┬──────┘
                                               │
                                               ▼
                                        ┌─────────────┐
                                        │    Human    │
                                        │   Approval  │
                                        └─────────────┘
```

1. **Document Integration**: The Document Assembler combines all elements into a cohesive world bible
2. **Consistency Checking**: Contradictions and inconsistencies are identified and resolved
3. **Formatting and Enhancement**: The document is structured for readability with additional details
4. **Final Checkpoint**: The complete world bible is presented for human approval

**File-Based Memory**:
- `world_bible_draft.md`: Initial assembled document
- `consistency_notes.md`: Identified issues and resolutions
- `world_bible_final.md`: Final formatted document
- `questions_final.md`: Any final questions for human review
- `feedback_final.md`: Final human feedback and approval

**Human Interaction**:
- Humans review the complete world bible
- Final modifications can be requested
- Once approved, the world bible is finalized

### 4. Flexible Input Mechanisms

The system supports two primary modes of human input throughout the process:

#### Structured Options

```
Question: What type of magic system should exist in this world?
Options:
1. Elemental magic tied to natural forces
2. Ritualistic magic requiring specific components
3. Innate abilities present in certain bloodlines
4. No magic, focus on realistic technology instead
```

- Presents clear choices for key decisions
- Reduces cognitive load on humans
- Ensures system can process responses predictably
- Includes option for "Other" with free text input

#### Unstructured Modifications

```
Please review the character profile below and make any desired changes:

[Character profile text]

Your modifications:
```

- Allows for creative freedom and unexpected additions
- Supports direct editing of any content
- Accommodates complex ideas that don't fit structured options
- Enables human creativity to enhance the world

**Implementation**:
- Each checkpoint includes both structured and unstructured input options
- Humans can choose their preferred input method
- The system processes both types of input appropriately
- All input is stored in the file-based memory system for reference

## Technical Implementation

### File-Based Memory System

The system uses a simple file-based approach to maintain state and enable easy human intervention:

```
project/
├── input/
│   └── raw_input.md           # Original unstructured input
├── analysis/
│   ├── content_analysis.json  # Extracted genre, themes, etc.
│   ├── questions_round1.md    # Initial questions for human review
│   └── feedback_round1.md     # Human responses to initial questions
├── world_elements/
│   ├── characters.md          # Character profiles
│   ├── settings.md            # Locations and environments
│   ├── world_rules.md         # Systems and mechanics
│   ├── timeline.md            # Historical events
│   ├── questions_round2.md    # Questions about world elements
│   └── feedback_round2.md     # Human responses to element questions
└── output/
    ├── world_bible_draft.md   # Initial assembled document
    ├── consistency_notes.md   # Identified issues and resolutions
    ├── questions_final.md     # Final questions for human review
    ├── feedback_final.md      # Final human feedback
    └── world_bible_final.md   # Final approved document
```

This structure provides several advantages:
- Easy human inspection and modification at any stage
- Persistent storage that survives process restarts
- Clear organization of different types of information
- Simple version control using standard tools
- No complex database setup required

### Simplified State Schema

The system maintains a lightweight state that tracks the progress of the world bible generation:

```typescript
export const WorldBibleState = z.object({
  // Process tracking
  currentStage: z.enum([
    "initialize",
    "content_analysis", 
    "human_feedback_round1",
    "world_creation",
    "human_feedback_round2",
    "document_assembly",
    "human_final_review",
    "complete"
  ]).default("initialize"),

  // File paths for the current process
  filePaths: z.object({
    inputFile: z.string().optional(),
    analysisFile: z.string().optional(),
    questionsFile: z.string().optional(),
    feedbackFile: z.string().optional(),
    outputFile: z.string().optional()
  }).default({}),

  // Human interaction tracking
  humanInteraction: z.object({
    pendingQuestions: z.array(z.string()).default([]),
    lastFeedbackTime: z.number().optional(),
    feedbackIncorporated: z.boolean().default(false)
  }).default({}),

  // Simple error tracking
  errors: z.array(z.string()).default([])
});
```

### Agent Implementation

Each agent in the system is implemented as a LangGraph node with simplified functionality:

```typescript
const contentAnalystAgent = async (
  state: WorldBibleStateType,
  config: RunnableConfig
): Promise<WorldBibleStateType> => {
  // Read input file
  const inputPath = state.filePaths.inputFile || "input/raw_input.md";
  const inputContent = await fs.readFile(inputPath, "utf-8");

  // Create analysis prompt
  const analysisPrompt = ChatPromptTemplate.fromMessages([
    ["system", `You are an expert content analyst specializing in narrative fiction.
    Analyze the provided content to identify genre, themes, tone, and key elements.
    Focus on extracting the core components that will be essential for world-building.`],
    ["human", `Analyze this content and extract key world-building elements:\n\n${inputContent}`],
  ]);

  const llm = new ChatOpenAI({
    temperature: 0.3,
    modelName: "gpt-4",
  });

  // Define analysis schema
  const analysisSchema = z.object({
    genre: z.string().describe("The primary genre of the content"),
    setting: z.string().describe("The general setting or environment"),
    themes: z.array(z.string()).describe("Main themes present in the content"),
    tone: z.string().describe("The overall tone or mood"),
    keyElements: z.array(z.string()).describe("Important elements for world-building")
  });

  const structuredLLM = llm.withStructuredOutput(analysisSchema);

  // Generate analysis
  const analysis = await structuredLLM.invoke(
    await analysisPrompt.invoke({})
  );

  // Write analysis to file
  const analysisPath = "analysis/content_analysis.json";
  await fs.writeFile(analysisPath, JSON.stringify(analysis, null, 2));

  // Generate questions for human feedback
  const questionPrompt = ChatPromptTemplate.fromMessages([
    ["system", `Based on the analysis of the content, generate 3-5 focused questions
    that will help clarify ambiguous elements or fill in gaps in the world-building information.
    These questions should address the most important decisions needed to proceed with world creation.`],
    ["human", `Analysis results: ${JSON.stringify(analysis)}\n\nGenerate focused questions for human feedback.`],
  ]);

  const questions = await llm.invoke(await questionPrompt.invoke({}));

  // Write questions to file
  const questionsPath = "analysis/questions_round1.md";
  await fs.writeFile(questionsPath, questions.content);

  // Update state
  return {
    ...state,
    currentStage: "human_feedback_round1",
    filePaths: {
      ...state.filePaths,
      inputFile: inputPath,
      analysisFile: analysisPath,
      questionsFile: questionsPath
    },
    humanInteraction: {
      ...state.humanInteraction,
      pendingQuestions: questions.content.split("\n").filter(q => q.trim().endsWith("?")),
      feedbackIncorporated: false
    }
  };
};
```

### Simplified Graph Definition

The workflow is defined as a streamlined LangGraph with clear transitions between stages:

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

  // Add agent nodes
  graph.addNode("processCoordinator", processCoordinatorAgent);
  graph.addNode("contentAnalyst", contentAnalystAgent);
  graph.addNode("worldCreator", worldCreatorAgent);
  graph.addNode("documentAssembler", documentAssemblerAgent);
  graph.addNode("humanFeedback", humanFeedbackNode);

  // Define the edges of the graph
  graph.addEdge("__start__", "processCoordinator");

  // Process coordinator manages workflow transitions
  graph.addConditionalEdges(
    "processCoordinator",
    (state) => state.currentStage,
    {
      initialize: "contentAnalyst",
      human_feedback_round1: "humanFeedback",
      world_creation: "worldCreator",
      human_feedback_round2: "humanFeedback",
      document_assembly: "documentAssembler",
      human_final_review: "humanFeedback",
      complete: "__end__",
    }
  );

  // Agent return paths
  graph.addEdge("contentAnalyst", "processCoordinator");
  graph.addEdge("worldCreator", "processCoordinator");
  graph.addEdge("documentAssembler", "processCoordinator");
  graph.addEdge("humanFeedback", "processCoordinator");

  // Compile the graph
  return graph.compile();
};
```

This simplified graph focuses on the core workflow stages with clear transitions between analysis, creation, assembly, and human feedback checkpoints. The process coordinator manages the overall flow and ensures that each stage is completed before moving to the next.

## Practical Implementation Considerations

### 1. Getting Started with File-Based Memory

The file-based memory system is straightforward to implement:

1. **Directory Setup**
   ```bash
   mkdir -p input analysis world_elements output
   ```

2. **Initial File Creation**
   ```bash
   # Create a template for raw input
   echo "# World Building Input\n\nEnter your initial ideas here..." > input/raw_input.md

   # Create placeholder for analysis results
   echo "{}" > analysis/content_analysis.json
   ```

3. **File Monitoring**
   - Use file system watchers to detect when humans modify files
   - Implement simple polling mechanisms to check for file changes
   - Create backup copies before making automated changes

4. **Version Control Integration**
   - Use Git to track changes to all files
   - Create commits at each workflow stage
   - Enable easy rollback to previous versions

### 2. Human Interaction Patterns

The system supports several practical human interaction patterns:

#### Question Bundling

Instead of interrupting humans with frequent questions, bundle related questions together:

```markdown
# World Creation Questions - Round 1

Please answer the following questions to guide the world creation process:

1. SETTING: The analysis suggests a post-apocalyptic setting. Should this be:
   a) Near-future Earth
   b) Distant-future Earth
   c) Another planet entirely
   d) Other (please specify)

2. MAGIC/TECHNOLOGY: What level of supernatural or advanced technology exists?
   a) No magic, realistic technology only
   b) Limited supernatural elements
   c) Advanced technology indistinguishable from magic
   d) Full magic system with defined rules
   e) Other (please specify)

3. TONE: What overall tone should the world have?
   a) Grim and hopeless
   b) Challenging but with hope
   c) Neutral/realistic
   d) Optimistic despite challenges
   e) Other (please specify)

4. FOCUS: Which aspect should receive the most detailed development?
   a) Character relationships and societies
   b) Physical environment and geography
   c) Historical events and timeline
   d) Systems (magic, technology, politics)
   e) Other (please specify)

5. ADDITIONAL NOTES: Please add any other guidance or specific elements you want included.
```

#### Structured Feedback Forms

Provide templates for human feedback that make it easy to provide input:

```markdown
# World Element Feedback - Characters

## Character: Elara Voss (Protagonist)

Current description:
A former military engineer who survived the collapse by using her technical skills.
Now leads a small community of survivors, struggling with the burden of leadership.

Your feedback:
[ ] Keep as is
[ ] Minor revisions needed
[ ] Major revisions needed

Specific changes or additions:
_________________________________________________
_________________________________________________

## Character: The Archivist (Antagonist)

Current description:
A mysterious figure who collects and hoards pre-collapse technology, believing
humanity doesn't deserve a second chance with advanced tools.

Your feedback:
[ ] Keep as is
[ ] Minor revisions needed
[ ] Major revisions needed

Specific changes or additions:
_________________________________________________
_________________________________________________
```

### 3. Handling Edge Cases

The simplified workflow needs to handle several common edge cases:

#### Conflicting Human Feedback

When humans provide contradictory feedback across different stages:

1. Identify the contradiction explicitly
2. Present both versions side-by-side
3. Ask for clarification on which should take precedence
4. Document the decision in `consistency_notes.md`

#### Incomplete Information

When critical information is missing despite human feedback:

1. Make reasonable assumptions based on genre conventions
2. Clearly mark these assumptions in the output
3. Bundle questions about these assumptions in the next feedback round
4. Allow easy overriding of any assumptions

#### Technical Failures

When system components fail:

1. Save all current state to files immediately
2. Create detailed error logs with context
3. Implement automatic resumption from last checkpoint
4. Provide manual override options for humans

### 4. Scaling for Different Project Sizes

The system can be adjusted based on project scope:

#### Small Projects (Short Stories, Single Scenes)
- Use a single feedback round instead of multiple checkpoints
- Focus on only the most essential world elements
- Simplify the file structure to fewer files
- Use a more condensed output format

#### Medium Projects (Novels, Game Settings)
- Use the standard three-checkpoint workflow as described
- Implement the complete file structure
- Focus on all core world elements
- Generate comprehensive documentation

#### Large Projects (Series, Franchises)
- Add additional feedback checkpoints for more granular control
- Expand the file structure with subdirectories for element categories
- Implement cross-referencing between related elements
- Create supplementary visualization files (maps, timelines, relationship diagrams)

### 5. Integration with Other Tools

The file-based approach makes integration with other tools straightforward:

#### Text Editors and IDEs
- Files can be opened in any text editor for human modification
- Markdown format ensures compatibility with preview features
- JSON files can be validated with standard tools

#### Visualization Tools
- Timeline data can be exported to timeline visualization tools
- Character relationship data can generate network graphs
- Setting descriptions can be used as prompts for image generation

#### Version Control Systems
- All files can be tracked in Git or other VCS
- Branching can be used to explore alternative world versions
- Merging can combine elements from different iterations

#### Publishing Platforms
- Final Markdown can be converted to various publishing formats
- HTML export for web publishing
- PDF generation for print materials
- Integration with wiki systems for interactive exploration

## Conclusion

This simplified agentic workflow provides a pragmatic approach to generating narrative world bibles that balances AI capabilities with human creativity and oversight. By focusing on iterative dialogue, file-based memory, simplified roles, and flexible input mechanisms, the system creates a collaborative environment where humans and AI work together effectively.

The design emphasizes:

1. **Human-Centered Collaboration**: Clear checkpoints ensure humans maintain creative control
2. **Practical Implementation**: File-based memory enables easy inspection and modification
3. **Simplified Architecture**: Streamlined agent roles focus on essential functions
4. **Iterative Refinement**: Multiple feedback loops improve quality incrementally
5. **Flexibility**: The system accommodates both structured and unstructured human input
6. **Accessibility**: Reduced complexity makes the system easier to implement and use
7. **Adaptability**: The approach can be scaled for projects of different sizes and complexity

This simplified workflow makes narrative world bible generation more accessible while maintaining the quality and depth needed for compelling fictional universes. It provides a practical foundation that can be implemented quickly for MVP projects and expanded as needed for more complex creative endeavors.
