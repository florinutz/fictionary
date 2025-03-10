/**
 * Unit tests for the add command module
 */

import { assertEquals } from '../../../src/deps.ts';
import { add } from '../../../src/commands/add.ts';

Deno.test('add function', async (t) => {
    await t.step('adds two positive numbers', () => {
        assertEquals(add(2, 3), 5);
    });

    await t.step('adds a positive and a negative number', () => {
        assertEquals(add(5, -3), 2);
    });

    await t.step('adds two negative numbers', () => {
        assertEquals(add(-2, -3), -5);
    });

    await t.step('adds zero and a number', () => {
        assertEquals(add(0, 5), 5);
        assertEquals(add(5, 0), 5);
    });
});
