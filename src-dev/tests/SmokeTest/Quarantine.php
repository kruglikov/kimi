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
     * §4/§7 — dated backup / dead module copies that error on load.
     *
     * The client approved deleting the copies under modules/gui/ticket_201502071142.php,
     * modules/gui/ticket_sich20150208.php and modules/initial/ticketsuch_sich20150208.php,
     * and those files are gone. The two basenames below stay quarantined because further
     * copies of the same dated backups survive in the other module sets
     * (modules/initial/ticket_sich20150208.php, modules/gui/ticketsuch_sich20150208.php,
     * modules/menu/ticketsuch_sich20150208.php) and the runners match by basename.
     */
    public const DEAD_BACKUP_MODULES = [
        'ticket_sich20150208.php',
        'ticketsuch_sich20150208.php',
    ];

    /** §7 — bundled tool + telephony/outbound endpoints, not load-testable offline. */
    public const NON_APP_TOPLEVEL = [
        'adminer-4.8.1.php',
        'setticketcallinfo.php',
        'xhangup.php',
        'testpost.php',
    ];

    /**
     * §6/§7 — modules that need a full case/customer ($akt/$kunde) context which the
     * direct-include runners (gui_runner/module_runner) do not build. Where routable
     * they are still covered by RouterSmokeTest via the real index.php (which builds the
     * context); otherwise verified in the Phase 3.3 functional tests. Not an 8.5 issue.
     */
    public const CONTEXT_DEPENDENT_MODULES = [
        'akt.php',
        'subdetail.php',
        'kunde_details.php',
        'subuebersicht.php',
    ];
}
