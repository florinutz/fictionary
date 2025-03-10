/**
 * Test fixtures for the application
 * This file provides test data that can be used across multiple tests
 */

/**
 * Sample test data for number operations
 */
export const numberTestData = {
    /**
     * Sample pairs of numbers for addition tests
     */
    additionPairs: [
        { a: 2, b: 3, expected: 5 },
        { a: 5, b: -3, expected: 2 },
        { a: -2, b: -3, expected: -5 },
        { a: 0, b: 5, expected: 5 },
        { a: 5, b: 0, expected: 5 },
    ],
};

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
