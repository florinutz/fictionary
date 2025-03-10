/**
 * General utility functions for the application
 */

import { logger } from './logger.ts';

/**
 * Retries a function until it succeeds or reaches the maximum number of retries
 * @param fn The function to retry
 * @param maxRetries Maximum number of retry attempts
 * @param delay Delay between retries in milliseconds
 * @returns The result of the function
 */
export async function retry<T>(
    fn: () => Promise<T>,
    maxRetries = 3,
    delay = 1000,
): Promise<T> {
    let lastError: Error | undefined;

    for (let attempt = 1; attempt <= maxRetries + 1; attempt++) {
        try {
            return await fn();
        } catch (error) {
            lastError = error instanceof Error ? error : new Error(String(error));

            if (attempt <= maxRetries) {
                logger.warn(
                    `Attempt ${attempt} failed, retrying in ${delay}ms...`,
                    lastError,
                );
                await new Promise((resolve) => setTimeout(resolve, delay));
                // Exponential backoff
                delay *= 2;
            }
        }
    }

    throw lastError;
}

/**
 * Formats a number with commas as thousands separators
 * @param num The number to format
 * @returns The formatted number string
 */
export function formatNumber(num: number): string {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

/**
 * Truncates a string to a specified length and adds an ellipsis if truncated
 * @param str The string to truncate
 * @param maxLength The maximum length of the string
 * @returns The truncated string
 */
export function truncate(str: string, maxLength: number): string {
    if (str.length <= maxLength) {
        return str;
    }
    return str.slice(0, maxLength - 3) + '...';
}

/**
 * Generates a random string of a specified length
 * @param length The length of the random string
 * @returns A random string
 */
export function randomString(length: number): string {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let result = '';

    for (let i = 0; i < length; i++) {
        const randomIndex = Math.floor(Math.random() * chars.length);
        result += chars.charAt(randomIndex);
    }

    return result;
}
