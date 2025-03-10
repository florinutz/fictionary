/**
 * Integration tests for the CLI application
 */

import { assertEquals } from "../../src/deps.ts";
import { numberTestData, createMockConsole } from "../fixtures/test_data.ts";
import { addCommand } from "../../src/commands/add.ts";

// Mock console for testing output
const mockConsole = createMockConsole();
const originalConsoleLog = console.log;

Deno.test("CLI commands integration", async (t) => {
    // Setup: Replace console.log with mock
    console.log = mockConsole.log;

    await t.step("add command outputs correct result", async () => {
        // Clear previous output
        mockConsole.clear();
        
        // Test each addition pair
        for (const pair of numberTestData.additionPairs) {
            // Execute the command action directly
            await addCommand.action(
                // The first parameter is the options object, which we don't use here
                {},
                pair.a,
                pair.b
            );
            
            // Check the last output matches expected format
            const output = mockConsole.getOutput();
            const lastOutput = output[output.length - 1];
            assertEquals(lastOutput, `${pair.a} + ${pair.b} = ${pair.expected}`);
        }
    });

    // Teardown: Restore original console.log
    console.log = originalConsoleLog;
});