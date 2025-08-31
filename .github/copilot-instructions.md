# GitHub Copilot Instructions

## Priority Guidelines

When generating code for this repository:

1. **Version Compatibility**: Always detect and respect the exact versions of languages, frameworks, and libraries used in this project
2. **Context Files**: Prioritize patterns and standards defined in the .github/copilot directory
3. **Codebase Patterns**: When context files don't provide specific guidance, scan the codebase for established patterns
4. **Architectural Consistency**: Maintain our Layered architectural style and established boundaries
5. **Code Quality**: Prioritize maintainability, performance, security, accessibility, and testability in all generated code

## Technology Version Detection

Before generating code, scan the codebase to identify:

1. **Language Versions**: Detect the exact versions of programming languages in use
   - Examine project files, configuration files, and package managers
   - Look for language-specific version indicators (e.g., PHP ^8.2 in composer.json)
   - Never use language features beyond the detected version

2. **Framework Versions**: Identify the exact versions of all frameworks
   - Check composer.json, package.json, etc.
   - Respect version constraints when generating code
   - Never suggest features not available in the detected framework versions

3. **Library Versions**: Note the exact versions of key libraries and dependencies
   - Generate code compatible with these specific versions
   - Never use APIs or features not available in the detected versions

## Context Files

Prioritize the following files in .github/copilot directory:
- [architecture.md](copilot/architecture.md): System architecture guidelines and blueprint
- [tech-stack.md](copilot/tech-stack.md): Technology stack details and version info
- [workflow.md](copilot/workflow.md): Project workflows and process blueprints
- [folder-structure.md](copilot/folder-structure.md): Project folder structure and organization
- [exemplars.md](copilot/exemplars.md): High-quality code examples and best practices

## Codebase Scanning Instructions

When context files don't provide specific guidance:
1. Identify similar files to the one being modified or created
2. Analyze patterns for:
   - Naming conventions
   - Code organization
   - Error handling
   - Logging approaches
   - Documentation style
   - Testing patterns
3. Follow the most consistent patterns found in the codebase
4. When conflicting patterns exist, prioritize patterns in newer files or files with higher test coverage
5. Never introduce patterns not found in the existing codebase

## Code Quality Standards

### Maintainability
- Write self-documenting code with clear naming
- Follow the naming and organization conventions evident in the codebase
- Follow established patterns for consistency
- Keep functions focused on single responsibilities
- Limit function complexity and length to match existing patterns

### Performance
- Follow existing patterns for memory and resource management
- Match existing patterns for handling computationally expensive operations
- Follow established patterns for asynchronous operations
- Apply caching consistently with existing patterns
- Optimize according to patterns evident in the codebase

### Security
- Follow existing patterns for input validation
- Apply the same sanitization techniques used in the codebase
- Use parameterized queries matching existing patterns
- Follow established authentication and authorization patterns
- Handle sensitive data according to existing patterns
- Check the code for vulnerabilities after generating.
- Avoid hardcoding sensitive information like credentials or API keys.
- Use secure coding practices and validate all inputs.

### Accessibility
- Follow existing accessibility patterns in the codebase
- Match ARIA attribute usage with existing components
- Maintain keyboard navigation support consistent with existing code
- Follow established patterns for color and contrast
- Apply text alternative patterns consistent with the codebase

### Testability
- Follow established patterns for testable code
- Match dependency injection approaches used in the codebase
- Apply the same patterns for managing dependencies
- Follow established mocking and test double patterns
- Match the testing style used in existing tests

## Documentation Requirements
- Follow the most detailed documentation patterns found in the codebase
- Match the style and completeness of the best-documented code
- Document exactly as the most thoroughly documented files do
- Follow existing patterns for linking documentation
- Match the level of detail in explanations of design decisions

## Testing Approach
### Unit Testing
- Match the exact structure and style of existing unit tests
- Follow the same naming conventions for test classes and methods
- Use the same assertion patterns found in existing tests
- Apply the same mocking approach used in the codebase
- Follow existing patterns for test isolation

### Integration Testing
- Follow the same integration test patterns found in the codebase
- Match existing patterns for test data setup and teardown
- Use the same approach for testing component interactions
- Follow existing patterns for verifying system behavior

### End-to-End Testing
- Match the existing E2E test structure and patterns
- Follow established patterns for UI testing
- Apply the same approach for verifying user journeys

### Test-Driven Development
- Follow TDD patterns evident in the codebase
- Match the progression of test cases seen in existing code
- Apply the same refactoring patterns after tests pass

### Behavior-Driven Development
- Match the existing Given-When-Then structure in tests
- Follow the same patterns for behavior descriptions
- Apply the same level of business focus in test cases

## Technology-Specific Guidelines
### PHP/Laravel Guidelines
- Detect and adhere to the specific PHP and Laravel versions in use
- Follow the exact same design patterns found in the codebase
- Match exception handling patterns from existing code
- Use the same collection types and approaches found in the codebase
- Apply the dependency injection patterns evident in existing code

### JavaScript Guidelines
- Detect and adhere to the specific ECMAScript version in use
- Follow the same module import/export patterns found in the codebase
- Use the same async patterns (promises, async/await) as existing code
- Follow error handling patterns from similar files

### CSS/Tailwind Guidelines
- Use only TailwindCSS classes and patterns found in the codebase
- Match utility-first styling and responsive design patterns

## Version Control Guidelines
- Follow Semantic Versioning patterns as applied in the codebase
- Match existing patterns for documenting breaking changes
- Follow the same approach for deprecation notices
- Keep commits atomic and focused on single changes
- Follow conventional commit message format

## Change Logging
- Each time you generate code, note the changes in changelog.md
- Follow semantic versioning guidelines
- Include date and description of changes

## General Best Practices
- Follow naming conventions exactly as they appear in existing code
- Match code organization patterns from similar files
- Apply error handling consistent with existing patterns
- Follow the same approach to testing as seen in the codebase
- Match logging patterns from existing code
- Use the same approach to configuration as seen in the codebase

## Project-Specific Guidance
- Scan the codebase thoroughly before generating any code
- Respect existing architectural boundaries without exception
- Match the style and patterns of surrounding code
- When in doubt, prioritize consistency with existing code over external best practices or newer language features
