/**
 * Base model interfaces
 * This file defines the base interfaces for all domain models
 */

/**
 * Base model interface
 * All domain models should extend this interface
 */
export interface Model {
  /**
   * Unique identifier for the model
   */
  id: string;

  /**
   * Creation timestamp
   */
  createdAt: Date;

  /**
   * Last update timestamp
   */
  updatedAt: Date;
}

/**
 * Base metadata interface
 * Common metadata properties for domain models
 */
export interface Metadata {
  /**
   * Tags associated with the model
   */
  tags?: string[];

  /**
   * Custom properties
   */
  [key: string]: string | number | boolean | string[] | number[] | Record<string, unknown> | undefined;
}
