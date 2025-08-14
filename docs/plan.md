# Improvement Plan

This plan guides iterative improvements to the Cafe POS project. Work is tracked in docs/tasks.md. Changes should be small, safe, and quickly reviewable.

## Filament 4.x Upgrade Consideration
- Status: Under evaluation (2025-08-13)
- Rationale: Filament 4 brings design/UX updates and API changes; upgrade must align with plugin compatibility (Shield, Media Library plugin, date range filter, health plugin, table repeater, backgrounds).
- Next actions:
  - Verify plugin compatibility matrices for Filament 4 and Laravel 12.
  - Prepare a branch to bump dependencies and run artisan filament:upgrade.
  - Adapt breaking changes in Resources, Forms, Tables only after CI baseline is green.

## Priorities (Phase 1)
1. Foundation docs and environment hygiene
2. Baseline tooling and CI
   - Composer/npm scripts for linting, static analysis, and tests
   - Prepare CI workflow skeleton
3. Security and data integrity
4. Testing coverage
   - Domain models, feature flows, and Filament resources

## Approach
- Implement tasks top-down from docs/tasks.md, batching only closely-related items.
- Keep changes minimal and isolated, with clear commit messages referencing task numbers.
- Prefer documentation and configuration guardrails before large code refactors.

## Done Criteria
- Each completed task is marked [x] in docs/tasks.md.
- Documentation updated where relevant.
- No secrets or plaintext credentials committed.
