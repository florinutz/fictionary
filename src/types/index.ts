/**
 * Type definitions for the application
 */

/**
 * Represents a pair of numbers for addition
 */
export interface AdditionPair {
    /**
     * First number
     */
    a: number;
    
    /**
     * Second number
     */
    b: number;
    
    /**
     * Expected result of adding a and b
     */
    expected: number;
}

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