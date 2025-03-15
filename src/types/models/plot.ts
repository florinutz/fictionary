/**
 * Plot model interfaces
 * This file defines the interfaces for plot elements and related entities
 */

import { Model } from './base.ts';

/**
 * Plot point in a story
 */
export interface PlotPoint {
    /**
     * Title of the plot point
     */
    title: string;

    /**
     * Description of the plot point
     */
    description: string;

    /**
     * Characters involved in this plot point
     */
    characters?: string[];

    /**
     * Locations where this plot point takes place
     */
    locations?: string[];
}

/**
 * Story arc
 */
export interface StoryArc {
    /**
     * Name of the story arc
     */
    name: string;

    /**
     * Description of the story arc
     */
    description: string;

    /**
     * Plot points in this arc
     */
    plotPoints?: PlotPoint[];
}

/**
 * Theme in the narrative
 */
export interface Theme {
    /**
     * Name of the theme
     */
    name: string;

    /**
     * Description of the theme
     */
    description: string;

    /**
     * Examples of how this theme is expressed
     */
    examples?: string[];
}

/**
 * Plot element in the narrative
 */
export interface PlotElement extends Model {
    /**
     * Title of the plot element
     */
    title: string;

    /**
     * Type of plot element (e.g., main plot, subplot)
     */
    type: string;

    /**
     * Description of the plot element
     */
    description: string;

    /**
     * Story arcs within this plot element
     */
    arcs?: StoryArc[];

    /**
     * Themes explored in this plot element
     */
    themes?: Theme[];

    /**
     * Conflicts driving this plot element
     */
    conflicts?: string[];

    /**
     * Resolution of this plot element
     */
    resolution?: string;
}

/**
 * Event in the timeline
 */
export interface TimelineEvent extends Model {
    /**
     * Title of the event
     */
    title: string;

    /**
     * Description of the event
     */
    description: string;

    /**
     * When the event occurs
     */
    date: string;

    /**
     * Characters involved in this event
     */
    characters?: string[];

    /**
     * Locations where this event takes place
     */
    locations?: string[];

    /**
     * Plot elements this event is part of
     */
    plotElements?: string[];

    /**
     * Significance or impact of this event
     */
    significance?: string;
}
