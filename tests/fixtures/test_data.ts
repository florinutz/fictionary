/**
 * Test fixtures for the application
 * This file provides test data that can be used across multiple tests
 */

/**
 * Helper function to create a mock console for testing output
 * @returns A mock console object with captured output
 */
export function createMockConsole(): {
    log: (message: string) => void;
    getOutput: () => string[];
    clear: () => void;
} {
    const output: string[] = [];

    return {
        log: (message: string): void => {
            output.push(message);
        },
        getOutput: (): string[] => {
            return [...output];
        },
        clear: (): void => {
            output.length = 0;
        },
    };
}
