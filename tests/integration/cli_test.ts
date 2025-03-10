/**
 * Integration tests for the CLI application
 */

import { assertEquals } from '../../src/deps.ts';
import { createMockConsole, numberTestData } from '../fixtures/test_data.ts';
import { add } from '../../src/commands/add.ts';
import { logger } from '../../src/lib/logger.ts';

// Mock console for testing output
const mockConsole = createMockConsole();
const originalConsoleLog = console.log;

Deno.test('CLI commands integration', async (t) => {
    // Setup: Replace console.log with mock
    console.log = mockConsole.log;

    await t.step('add command outputs correct result', async () => {
        // Clear previous output
        mockConsole.clear();

        // Test each addition pair
        for (const pair of numberTestData.additionPairs) {
            // Calculate the result using the add function
            const result = add(pair.a, pair.b);

            // Log the result using the logger, similar to how the command does it
            logger.info(`${pair.a} + ${pair.b} = ${result}`);

            // Check the last output matches expected format
            const output = mockConsole.getOutput();
            const lastOutput = output[output.length - 1];
            assertEquals(lastOutput, `${pair.a} + ${pair.b} = ${pair.expected}`);
        }
    });

    // Teardown: Restore original console.log
    console.log = originalConsoleLog;
});
