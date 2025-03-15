/**
 * World model interfaces
 * This file defines the interfaces for world building and related entities
 */

import { Model } from './base.ts';

/**
 * Physical laws or rules of the world
 */
export interface PhysicalLaws {
    /**
     * Description of the physical laws
     */
    description: string;

    /**
     * Specific rules or constraints
     */
    rules?: string[];
}

/**
 * Cultural element in the world
 */
export interface Culture {
    /**
     * Name of the culture
     */
    name: string;

    /**
     * Description of the culture
     */
    description: string;

    /**
     * Customs and traditions
     */
    customs?: string[];

    /**
     * Values and beliefs
     */
    values?: string[];

    /**
     * Social structure
     */
    socialStructure?: string;
}

/**
 * Technology level and capabilities
 */
export interface Technology {
    /**
     * Overall technology level
     */
    level: string;

    /**
     * Description of the technology
     */
    description: string;

    /**
     * Notable technologies
     */
    notableTechnologies?: string[];

    /**
     * Limitations of the technology
     */
    limitations?: string[];
}

/**
 * World settings and details
 */
export interface WorldSettings extends Model {
    /**
     * Name of the world
     */
    name: string;

    /**
     * Description of the world
     */
    description: string;

    /**
     * Physical characteristics of the world
     */
    physicalCharacteristics?: string;

    /**
     * Physical laws or rules
     */
    physicalLaws?: PhysicalLaws;

    /**
     * Cultures in the world
     */
    cultures?: Culture[];

    /**
     * Technology level and capabilities
     */
    technology?: Technology;

    /**
     * History of the world
     */
    history?: string;

    /**
     * Current state of the world
     */
    currentState?: string;

    /**
     * Major conflicts or issues
     */
    conflicts?: string[];
}
