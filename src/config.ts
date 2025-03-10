/**
 * Application configuration module
 * Handles loading and managing application configuration
 */

import { z } from './deps.ts';
import { AppConfig, DEFAULT_CONFIG } from './types/index.ts';
import { logger } from './lib/logger.ts';

/**
 * Configuration schema for validation
 */
const configSchema = z.object({
    debug: z.boolean().default(DEFAULT_CONFIG.debug),
    outputFormat: z.enum(['text', 'json']).default(DEFAULT_CONFIG.outputFormat),
    maxRetries: z.number().int().positive().default(DEFAULT_CONFIG.maxRetries),
});

/**
 * Loads configuration from environment variables
 * @returns Configuration from environment variables
 */
function loadEnvConfig(): Partial<AppConfig> {
    const config: Partial<AppConfig> = {};

    // Load debug mode from environment
    const debugEnv = Deno.env.get('FICTIONARY_DEBUG');
    if (debugEnv !== undefined) {
        config.debug = debugEnv === 'true' || debugEnv === '1';
    }

    // Load output format from environment
    const outputFormatEnv = Deno.env.get('FICTIONARY_OUTPUT_FORMAT');
    if (outputFormatEnv === 'text' || outputFormatEnv === 'json') {
        config.outputFormat = outputFormatEnv;
    }

    // Load max retries from environment
    const maxRetriesEnv = Deno.env.get('FICTIONARY_MAX_RETRIES');
    if (maxRetriesEnv !== undefined) {
        const maxRetries = parseInt(maxRetriesEnv, 10);
        if (!isNaN(maxRetries) && maxRetries > 0) {
            config.maxRetries = maxRetries;
        }
    }

    return config;
}

/**
 * Loads and validates application configuration
 * @returns Validated application configuration
 */
export function loadConfig(): AppConfig {
    // Start with default configuration
    const baseConfig = { ...DEFAULT_CONFIG };

    // Override with environment variables
    const envConfig = loadEnvConfig();
    const mergedConfig = { ...baseConfig, ...envConfig };

    // Validate the configuration
    const result = configSchema.safeParse(mergedConfig);

    if (!result.success) {
        logger.error('Invalid configuration:', new Error(result.error.message));
        return baseConfig;
    }

    return result.data;
}

/**
 * The application configuration
 */
export const config = loadConfig();
