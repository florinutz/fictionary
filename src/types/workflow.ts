/**
 * Workflow type definitions
 * This file defines the interfaces for workflow registration and execution
 */

/**
 * Output format options for workflow results
 */
export type OutputFormat = 'json' | 'yaml' | 'markdown';

/**
 * Options for workflow execution
 */
export interface WorkflowOptions {
    /**
     * Output format for the workflow result
     */
    outputFormat?: OutputFormat;

    /**
     * Level of detail for enrichment
     */
    enrichmentLevel?: 'basic' | 'standard' | 'detailed';

    /**
     * Categories to include in the output
     */
    categories?: string[];

    /**
     * File to save the output to
     */
    outputFile?: string;
}

/**
 * Base workflow interface
 * All workflows should implement this interface
 */
export interface Workflow<TInput, TOutput> {
    /**
     * Workflow name
     */
    name: string;

    /**
     * Workflow description
     */
    description: string;

    /**
     * Execute the workflow with the given input and options
     * @param input The input data for the workflow
     * @param options Optional configuration for the workflow execution
     * @returns The workflow result
     */
    execute(input: TInput, options?: WorkflowOptions): Promise<TOutput>;

    /**
     * Validate the input data
     * @param input The input data to validate
     * @returns The validated input data
     * @throws Error if the input is invalid
     */
    validateInput(input: unknown): TInput;

    /**
     * Format the output data according to the specified format
     * @param output The output data to format
     * @param format The desired output format
     * @returns The formatted output
     */
    formatOutput(output: TOutput, format: OutputFormat): string | object;
}
