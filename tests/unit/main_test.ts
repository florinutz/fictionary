import { assertEquals } from "../../src/deps.ts";
import { add } from "../../src/main.ts";

Deno.test(function addTest() {
    assertEquals(add(2, 3), 5);
});
