# Memory bank

@memory-bank/ consists of next files
- index.md - the current file, where all md files in memory should be listed so that AI Agents could do high level navigation through the memory bank
- ARCHITECTURE.md - project technical architecture described here
- batch-processing-subsystem.md - what the `kimibatch/` subsystem is: utilities, campaign scripts, campaigns list, per-campaign data file layout
- batch-docker-compatibility.md - environment-only strategy for making legacy `kimibatch/` scripts run inside the current Docker stack without changing `src/original-src/web/`
- php-smoke-test-safety-net.md - current PHP runtime smoke-test safety net: what is covered, how it is executed, known limitations, and links to the task-level inventory and implementation notes
