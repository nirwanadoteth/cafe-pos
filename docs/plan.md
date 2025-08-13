# Improvement Plan

This plan guides iterative improvements to the Cafe POS project. Work is tracked in docs/tasks.md. Changes should be small, safe, and quickly reviewable.

## Priorities (Phase 1)
1. Foundation docs and environment hygiene
   - Architecture overview and runtime topology
   - Env templates for local/staging/production with safe defaults
   - Remove plaintext credentials from docs
2. Baseline tooling and CI
   - Composer/npm scripts for linting, static analysis, and tests
   - Prepare CI workflow skeleton
3. Security and data integrity
   - Policies, validation centralization, database constraints
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
