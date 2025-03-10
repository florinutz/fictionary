/**
 * Unit tests for utility functions
 */

import { assertEquals, assertExists } from '$src/deps.ts';
import { formatNumber, randomString, truncate } from '$src/lib/utils.ts';

Deno.test('utils module', async (t) => {
    await t.step('formatNumber formats numbers with commas', () => {
        assertEquals(formatNumber(1000), '1,000');
        assertEquals(formatNumber(1000000), '1,000,000');
        assertEquals(formatNumber(1234567.89), '1,234,567.89');
        assertEquals(formatNumber(0), '0');
        assertEquals(formatNumber(-1000), '-1,000');
    });

    await t.step('truncate shortens strings correctly', () => {
        assertEquals(truncate('Hello, world!', 15), 'Hello, world!');
        assertEquals(truncate('Hello, world!', 10), 'Hello,...');
        assertEquals(truncate('Hello', 5), 'Hello');
        assertEquals(truncate('Hello', 3), '...');
    });

    await t.step('randomString generates strings of correct length', () => {
        const str5 = randomString(5);
        const str10 = randomString(10);
        const str20 = randomString(20);

        assertEquals(str5.length, 5);
        assertEquals(str10.length, 10);
        assertEquals(str20.length, 20);

        // Ensure strings are different (very low probability of collision)
        assertExists(str5);
        assertExists(str10);
        assertExists(str20);
    });

    await t.step('randomString generates strings with expected characters', () => {
        const str = randomString(100);
        const validChars = /^[A-Za-z0-9]+$/;

        assertEquals(validChars.test(str), true);
    });
});
