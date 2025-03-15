/**
 * Character model interfaces
 * This file defines the interfaces for characters and related entities
 */

import { Model } from './base.ts';

/**
 * Character trait
 */
export interface Trait {
    /**
     * Name of the trait
     */
    name: string;

    /**
     * Description of the trait
     */
    description: string;
}

/**
 * Character relationship
 */
export interface Relationship {
    /**
     * ID of the related character
     */
    characterId: string;

    /**
     * Type of relationship
     */
    type: string;

    /**
     * Description of the relationship
     */
    description: string;
}

/**
 * Character arc
 */
export interface CharacterArc {
    /**
     * Name of the arc
     */
    name: string;

    /**
     * Description of the arc
     */
    description: string;

    /**
     * Stages of the character arc
     */
    stages?: string[];
}

/**
 * Character in the narrative
 */
export interface Character extends Model {
    /**
     * Name of the character
     */
    name: string;

    /**
     * Role in the story (protagonist, antagonist, etc.)
     */
    role: string;

    /**
     * Character description
     */
    description: string;

    /**
     * Physical appearance
     */
    appearance?: string;

    /**
     * Character's personality traits
     */
    traits?: Trait[];

    /**
     * Character's motivations
     */
    motivations?: string[];

    /**
     * Character's goals
     */
    goals?: string[];

    /**
     * Character's conflicts
     */
    conflicts?: string[];

    /**
     * Character's background/history
     */
    background?: string;

    /**
     * Character's relationships with other characters
     */
    relationships?: Relationship[];

    /**
     * Character's arc throughout the story
     */
    arc?: CharacterArc;

    /**
     * Character's faction or group affiliations
     */
    factions?: string[];
}
