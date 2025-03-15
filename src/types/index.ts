/**
 * Type definitions for the application
 */

/**
 * Configuration options for the application
 */
export interface AppConfig {
    /**
     * Debug mode flag
     */
    debug: boolean;

    /**
     * Output format
     */
    outputFormat: 'text' | 'json';

    /**
     * Maximum number of retries for operations
     */
    maxRetries: number;
}

/**
 * Default configuration values
 */
export const DEFAULT_CONFIG: AppConfig = {
    debug: false,
    outputFormat: 'text',
    maxRetries: 3,
};
