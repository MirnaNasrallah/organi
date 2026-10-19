# ADR-0003: OpenAPI spec from Scramble, typed client from openapi-typescript

**Status:** Accepted
**Date:** 2026-10-18
**Deciders:** Mirna Nasrallah

## Context
Web and mobile must use one generated client (RULES §3), API types must come from the spec (RULES §4), and CI must catch drift between the spec and the code (RULES §7, contract layer). Mobile uses TanStack Query.

## Decision
- **Scramble** generates OpenAPI 3.1 from routes, Form Requests and API Resources. Add annotations only where Scramble cannot infer a type.
- The spec is committed as `packages/api-client/openapi.json`. CI regenerates it and fails if the result differs.
- **openapi-typescript** generates the TS types, **openapi-fetch** is the typed client, and **openapi-react-query** wraps it in TanStack Query hooks (`$api.useQuery('get', '/api/v1/recipes')`).
- Generated files are never edited by hand.

## Options considered
- **openapi-typescript + openapi-fetch + openapi-react-query (chosen):** types only, plus a few kB of runtime; API changes produce small, readable diffs.
- **Orval:** generates a hook per endpoint; more generated code and more config.
- **OpenAPI Generator:** a Java toolchain and verbose generated classes.

## Consequences
- Every API shape change shows up as an `openapi.json` diff in the same PR, so reviewers see it.
- Resources must return inferable types, not ad hoc arrays. That's a healthy constraint.
- Confirm Scramble supports Laravel 13 when scaffolding.
