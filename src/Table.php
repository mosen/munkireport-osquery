<?php


namespace Munkireport\Osquery;

/**
 * Static class to hold a pseudo enumeration of available tables in OSQuery.
 *
 * When you refer to an osquery table name, use this static class instead of the string literal.
 * It will allow for easier refactoring later on, and some implicit validation.
 *
 * @package Munkireport\Osquery
 */
class Table
{
    public static $startup_items = 'startup_items';
}
