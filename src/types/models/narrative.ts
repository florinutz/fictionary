/**
 * Narrative bible model interfaces
 * This file defines the interfaces for narrative bible and related entities
 */

import { Model, Metadata } from './base.ts';
import { Character } from './character.ts';
import { WorldSettings } from './world.ts';
import { PlotElement, TimelineEvent } from './plot.ts';

/**
 * Metadata specific to narrative bibles
 */
export interface BibleMetadata extends Metadata {
  /**
   * Genre of the narrative
   */
  genre?: string[];
  
  /**
   * Target audience
   */
  audience?: string;
  
  /**
   * Tone of the narrative
   */
  tone?: string[];
}

/**
 * Location in the narrative world
 */
export interface Location extends Model {
  /**
   * Name of the location
   */
  name: string;
  
  /**
   * Description of the location
   */
  description: string;
  
  /**
   * Notable features of the location
   */
  features?: string[];
  
  /**
   * Parent location (if this is a sub-location)
   */
  parentLocation?: string;
}

/**
 * Faction or group in the narrative world
 */
export interface Faction extends Model {
  /**
   * Name of the faction
   */
  name: string;
  
  /**
   * Description of the faction
   */
  description: string;
  
  /**
   * Goals or motivations of the faction
   */
  goals?: string[];
  
  /**
   * Relationships with other factions
   */
  relationships?: Record<string, string>;
}

/**
 * Magic system in the narrative world
 */
export interface MagicSystem extends Model {
  /**
   * Name of the magic system
   */
  name: string;
  
  /**
   * Description of the magic system
   */
  description: string;
  
  /**
   * Rules or limitations of the magic system
   */
  rules?: string[];
  
  /**
   * Sources of magic power
   */
  sources?: string[];
}

/**
 * Complete narrative bible
 */
export interface NarrativeBible extends Model {
  /**
   * Title of the narrative
   */
  title: string;
  
  /**
   * Description or high-level summary
   */
  description: string;
  
  /**
   * Metadata about the narrative
   */
  metadata: BibleMetadata;
  
  /**
   * World settings and details
   */
  world: WorldSettings;
  
  /**
   * Characters in the narrative
   */
  characters: Character[];
  
  /**
   * Plot elements and story arcs
   */
  plots: PlotElement[];
  
  /**
   * Magic systems in the world
   */
  magicSystems: MagicSystem[];
  
  /**
   * Timeline of events
   */
  timeline: TimelineEvent[];
  
  /**
   * Locations in the world
   */
  locations: Location[];
  
  /**
   * Factions or groups in the world
   */
  factions: Faction[];
}