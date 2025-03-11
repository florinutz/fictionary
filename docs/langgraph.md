`# LangGraph Integration Plan for Fictionary

## Overview

This document outlines the high-level plan for integrating LangChain and LangGraph into the Fictionary application, with a focus on enabling the development of agentic workflows. The plan is designed to leverage JSR imports (as defined in deno.json) and maintain compatibility with the existing application structure.

## Current Application Structure

Fictionary is a Deno-based CLI application with the following structure:

- **src/main.ts**: Entry point that sets up the CLI command structure
- **src/deps.ts**: Central file for managing dependencies
- **src/commands/**: Directory containing command modules
- **src/lib/**: Directory containing utility modules
- **src/types/**: Directory containing type definitions

## Integration Strategy

### 1. Update Dependencies

The application already has the necessary dependencies defined in deno.json:

```json
"imports": {
    "@langchain/core": "npm:@langchain/core@^0.3.42",
    "@langchain/community": "npm:@langchain/community@^0.3.34",
    "@langchain/langgraph": "npm:@langchain/langgraph@^0.2.54",
    // other dependencies...
}
```

We need to update the src/deps.ts file to export these dependencies for use throughout the application:

```typescript
// LangChain and LangGraph dependencies
export * from "@langchain/core";
export * from "@langchain/community";
export * from "@langchain/langgraph";
```

### 2. Create LangGraph Module Structure

Following the recommended structure for LangGraph applications, we'll create the following directory structure:

```
src/
├── langgraph/
│   ├── agents/
│   │   └── world_bible/
│   │       ├── index.ts
│   │       ├── state.ts
│   │       ├── nodes.ts
│   │       └── tools.ts
│   ├── utils/
│   │   ├── models.ts
│   │   ├── prompts.ts
│   │   └── schemas.ts
│   └── index.ts
```

This structure allows for:
- Modular agent definitions
- Reusable utilities
- Clear separation of concerns

### 3. Define Core Abstractions

#### Models Configuration

Create a centralized configuration for language models in `src/langgraph/utils/models.ts`:

```typescript
import { ChatOpenAI } from "@langchain/core/language_models/chat_models";

export const createChatModel = (options = {}) => {
    return new ChatOpenAI({
        temperature: 0.7,
        ...options,
    });
};
```

#### Schema Definitions

Define schemas for structured data extraction in `src/langgraph/utils/schemas.ts` using Zod:

```typescript
import { z } from "zod";

export const characterSchema = z.object({
    name: z.string().describe("The character's name"),
    description: z.string().describe("Physical description and personality"),
    background: z.string().describe("Character's history and background"),
    motivations: z.string().describe("Character's goals and motivations"),
    // Additional character attributes...
});

// Additional schemas for settings, plot elements, etc.
```

#### Prompt Templates

Create reusable prompt templates in `src/langgraph/utils/prompts.ts`:

```typescript
import { ChatPromptTemplate } from "@langchain/core/prompts";

export const extractionPrompt = ChatPromptTemplate.fromMessages([
    ["system", "You are an expert at extracting structured information from text."],
    ["human", "{text}"]
]);

// Additional prompt templates...
```

### 4. Implement Graph Components

For each agent, we'll define:

1. **State**: The data structure that represents the agent's state
2. **Nodes**: The functions that process the state
3. **Tools**: The tools that the agent can use
4. **Graph**: The definition of the agent's workflow

### 5. Create CLI Commands

Add new commands to the CLI for interacting with the LangGraph agents:

```typescript
// src/commands/generate.ts
import { Command } from "../deps.ts";
import { worldBibleAgent } from "../langgraph/agents/world_bible/index.ts";

export const generateCommand = new Command()
    .name("generate")
    .description("Generate content using LangGraph agents")
    .action(() => {
        // Show help for the generate command
        generateCommand.showHelp();
    });

export const worldBibleCommand = new Command()
    .name("world-bible")
    .description("Generate a narrative world bible from local unstructured data")
    .option("-i, --input <path:string>", "Path to input directory or file", { required: true })
    .option("-o, --output <path:string>", "Path to output directory", { default: "./output" })
    .action(async (options) => {
        // Call the world bible agent
        await worldBibleAgent.invoke({
            input_path: options.input,
            output_path: options.output,
        });
    });

// Add the world-bible command as a subcommand of generate
generateCommand.command("world-bible", worldBibleCommand);
```

Update `src/commands/index.ts` to export the new command:

```typescript
export * from "./add.ts";
export * from "./generate.ts";
```

Update `src/main.ts` to include the new command:

```typescript
import { Command } from "$src/deps.ts";
import { addCommand, generateCommand } from "$src/commands/index.ts";

// Create the main CLI command
const cli = new Command()
    .name("fictionary")
    .version("0.1.0")
    .description("A modern CLI TypeScript application")
    .action(() => {
        // Display help information when no subcommand is provided
        cli.showHelp();
    });

// Add subcommands
cli.command("add", addCommand);
cli.command("generate", generateCommand);
```

## Integration with Existing Code

The integration is designed to be non-invasive, adding new functionality without modifying existing code. This is achieved by:

1. Adding new dependencies to the existing deps.ts file
2. Creating new modules in a separate directory structure
3. Adding new commands to the CLI without modifying existing commands

## Testing Strategy

1. **Unit Tests**: Test individual components (nodes, tools, etc.)
2. **Integration Tests**: Test the interaction between components
3. **End-to-End Tests**: Test the complete workflow

## Deployment Considerations

1. **Environment Variables**: Store API keys and other sensitive information in environment variables
2. **Configuration**: Use a configuration file for customizable settings
3. **Error Handling**: Implement robust error handling and logging

## Next Steps

1. Implement the world bible generation agent (see plan.md)
2. Add additional agents for other workflows
3. Enhance the CLI with more commands and options
4. Add visualization tools for debugging and monitoring

## References

- [LangChain Core Concepts](./langchain-core/concepts/lcel.mdx)
- [LangGraph Agent Architectures](./langgraph/concepts/agentic_concepts.md)
- [LangGraph Application Structure](./langgraph/concepts/application_structure.md)