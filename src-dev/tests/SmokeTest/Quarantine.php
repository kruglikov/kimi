<?php

namespace KimiTest\SmokeTest;

/**
 * Modules quarantined from the smoke suite because they cannot pass in this
 * environment for reasons unrelated to PHP 8.5 — kept here so a red suite means
 * a real regression. See tasks/07-implement-deployment-to-dev/05-smoke-failures-inventory.md.
 */
final class Quarantine
{
    /**
     * §1 — insurance/claims modules that query tables absent from `kimidev_et`
     * (verified absent locally AND on the dev server). One basename covers the
     * gui/initial/menu copies of the same module.
     */
    public const ABSENT_FEATURE_MODULES = [
        'bankleitzahl.php',
        'buchungen.php',
        'inkassoinformation.php',
        'kundenhistorie.php',
        'lastschrift.php',
        'schadensfall.php',
        'schadensfall_art.php',
        'stammdaten.php',
        'stammsuche.php',
        'status_schadensfall.php',
        'versicherung.php',
    ];

    /**
     * §2 — batch scripts using the `mysql_*` API removed in PHP 7.0 (broken on the
     * server too). Kept separate from ABSENT_FEATURE_MODULES so the client
     * keep/migrate/remove decision can un-quarantine them one at a time.
     */
    public const LEGACY_MYSQL_SCRIPTS = [
        'inko201604_status_offen_auf_inA_setzen.php',
        'inkode04_status_offen_auf_inA_setzen.php',
        'inkodeexp_new.php',
        'oko04_status_offen_auf_inA_setzen.php',
        'oko04_status_offen_vortage_auf_inA_setzen.php',
        'oko_inA_outbound_elsbeth.php',
        'okoexpzwb.php',
    ];

    /** §4/§7 — dated backup / dead module copies that error on load. */
    public const DEAD_BACKUP_MODULES = [
        'ticket_201502071142.php',
        'ticket_sich20150208.php',
        'ticketsuch_sich20150208.php',
    ];

    /** §7 — bundled tool + telephony redirect endpoints, not load-testable offline. */
    public const NON_APP_TOPLEVEL = [
        'adminer-4.8.1.php',
        'setticketcallinfo.php',
        'xhangup.php',
    ];
}
