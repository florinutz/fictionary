/**
 * Workflow registry
 * This module provides a registry for workflows and a mechanism for discovering and registering workflows
 */

import { Workflow } from '../types/workflow.ts';
import { logger } from '../lib/logger.ts';

/**
 * Workflow registry class
 * Manages the registration and discovery of workflows
 */
export class WorkflowRegistry {
    /**
     * Map of workflow names to workflow instances
     */
    private workflows = new Map<string, Workflow<unknown, unknown>>();

    /**
     * Register a workflow with the registry
     * @param workflow The workflow to register
     */
    register<TInput, TOutput>(workflow: Workflow<TInput, TOutput>): void {
        if (this.workflows.has(workflow.name)) {
            logger.warn(`Workflow ${workflow.name} is already registered. Overwriting.`);
        }
        this.workflows.set(workflow.name, workflow as Workflow<unknown, unknown>);
        logger.debug(`Registered workflow: ${workflow.name}`);
    }

    /**
     * Get a workflow by name
     * @param name The name of the workflow to get
     * @returns The workflow instance, or undefined if not found
     */
    getWorkflow<TInput, TOutput>(name: string): Workflow<TInput, TOutput> | undefined {
        return this.workflows.get(name) as Workflow<TInput, TOutput> | undefined;
    }

    /**
     * Get all registered workflows
     * @returns An array of all registered workflow instances
     */
    getAllWorkflows(): Workflow<unknown, unknown>[] {
        return Array.from(this.workflows.values());
    }

    /**
     * Discover and register workflows from a directory
     * @param directory The directory to discover workflows from
     */
    async discoverWorkflows(directory: string): Promise<void> {
        try {
            for await (const entry of Deno.readDir(directory)) {
                if (
                    entry.isFile && entry.name.endsWith('.ts') && entry.name !== 'index.ts' &&
                    entry.name !== 'registry.ts'
                ) {
                    const modulePath = `${directory}/${entry.name}`;
                    try {
                        const module = await import(modulePath);

                        // Look for exported workflow instances
                        for (const [exportName, exportValue] of Object.entries(module)) {
                            if (
                                exportName.endsWith('Workflow') &&
                                typeof exportValue === 'object' &&
                                exportValue !== null &&
                                'name' in exportValue &&
                                'description' in exportValue &&
                                'execute' in exportValue &&
                                'validateInput' in exportValue &&
                                'formatOutput' in exportValue
                            ) {
                                this.register(exportValue as Workflow<unknown, unknown>);
                            }
                        }
                    } catch (error) {
                        const errorMessage = error instanceof Error ? error.message : String(error);
                        logger.error(
                            `Error importing workflow module ${modulePath}: ${errorMessage}`,
                        );
                    }
                }
            }
        } catch (error) {
            const errorMessage = error instanceof Error ? error.message : String(error);
            logger.error(`Error discovering workflows in ${directory}: ${errorMessage}`);
        }
    }
}

/**
 * Singleton instance of the workflow registry
 */
export const workflowRegistry = new WorkflowRegistry();
