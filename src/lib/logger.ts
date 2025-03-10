/**
 * Logger utility module
 * Provides logging functionality for the application
 */

import { colors, log } from "../deps.ts";
import { AppConfig, DEFAULT_CONFIG } from "../types/index.ts";

/**
 * Log levels
 */
export enum LogLevel {
    DEBUG = "DEBUG",
    INFO = "INFO",
    WARN = "WARN",
    ERROR = "ERROR",
}

/**
 * Logger class for handling application logging
 */
export class Logger {
    private config: AppConfig;

    /**
     * Creates a new Logger instance
     * @param config Optional configuration options
     */
    constructor(config: Partial<AppConfig> = {}) {
        this.config = { ...DEFAULT_CONFIG, ...config };
    }

    /**
     * Logs a debug message
     * @param message The message to log
     * @param data Optional data to include in the log
     */
    debug(message: string, data?: unknown): void {
        if (this.config.debug) {
            this.log(LogLevel.DEBUG, message, data);
        }
    }

    /**
     * Logs an info message
     * @param message The message to log
     * @param data Optional data to include in the log
     */
    info(message: string, data?: unknown): void {
        this.log(LogLevel.INFO, message, data);
    }

    /**
     * Logs a warning message
     * @param message The message to log
     * @param data Optional data to include in the log
     */
    warn(message: string, data?: unknown): void {
        this.log(LogLevel.WARN, message, data);
    }

    /**
     * Logs an error message
     * @param message The message to log
     * @param error Optional error to include in the log
     */
    error(message: string, error?: Error): void {
        this.log(LogLevel.ERROR, message, error);
    }

    /**
     * Internal method for logging messages
     * @param level The log level
     * @param message The message to log
     * @param data Optional data to include in the log
     */
    private log(level: LogLevel, message: string, data?: unknown): void {
        const timestamp = new Date().toISOString();
        let formattedMessage = `[${timestamp}] ${level}: ${message}`;

        // Apply colors based on log level
        switch (level) {
            case LogLevel.DEBUG:
                formattedMessage = colors.gray(formattedMessage);
                break;
            case LogLevel.INFO:
                formattedMessage = colors.blue(formattedMessage);
                break;
            case LogLevel.WARN:
                formattedMessage = colors.yellow(formattedMessage);
                break;
            case LogLevel.ERROR:
                formattedMessage = colors.red(formattedMessage);
                break;
        }

        // Output the log message
        console.log(formattedMessage);

        // Output additional data if provided
        if (data) {
            if (data instanceof Error) {
                console.log(colors.red(data.stack || data.message));
            } else if (this.config.outputFormat === "json") {
                console.log(JSON.stringify(data, null, 2));
            } else {
                console.log(data);
            }
        }
    }
}

/**
 * Default logger instance
 */
export const logger = new Logger();