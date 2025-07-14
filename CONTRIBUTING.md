# Contributing to Task Management System

Thank you for considering contributing to our Task Management System! This document provides guidelines and information for contributors.

## 🤝 How to Contribute

### Reporting Bugs

1. **Check existing issues** first to avoid duplicates
2. **Use the bug report template** when creating new issues
3. **Provide detailed information** including:
   - Steps to reproduce
   - Expected vs actual behavior
   - Environment details (OS, PHP version, etc.)
   - Screenshots if applicable

### Suggesting Features

1. **Check existing feature requests** to avoid duplicates
2. **Use the feature request template**
3. **Explain the use case** and why it would be valuable
4. **Consider implementation complexity**

### Code Contributions

#### Prerequisites
- PHP 8.1+
- Node.js 16+
- MySQL 8.0+
- Git knowledge

#### Development Setup
1. Fork the repository
2. Clone your fork locally
3. Follow the installation instructions in README.md
4. Create a new branch for your feature/fix

#### Coding Standards

**PHP/Laravel:**
- Follow PSR-12 coding standards
- Use meaningful variable and method names
- Add PHPDoc comments for methods
- Write tests for new functionality

**JavaScript/Vue.js:**
- Use ES6+ syntax
- Follow Vue.js style guide
- Use meaningful component and variable names
- Add JSDoc comments where appropriate

**Database:**
- Use descriptive migration names
- Include rollback methods in migrations
- Follow Laravel naming conventions

#### Pull Request Process

1. **Create a feature branch**
   \`\`\`bash
   git checkout -b feature/your-feature-name
   \`\`\`

2. **Make your changes**
   - Write clean, documented code
   - Add tests if applicable
   - Update documentation if needed

3. **Test your changes**
   \`\`\`bash
   # Run PHP tests
   php artisan test
   
   # Run frontend tests
   npm run test
   \`\`\`

4. **Commit your changes**
   \`\`\`bash
   git add .
   git commit -m "Add: Brief description of your changes"
   \`\`\`

5. **Push to your fork**
   \`\`\`bash
   git push origin feature/your-feature-name
   \`\`\`

6. **Create a Pull Request**
   - Use the PR template
   - Link related issues
   - Provide clear description of changes

## 📋 Issue Templates

### Bug Report Template
\`\`\`markdown
**Bug Description**
A clear description of the bug.

**Steps to Reproduce**
1. Go to '...'
2. Click on '....'
3. Scroll down to '....'
4. See error

**Expected Behavior**
What you expected to happen.

**Actual Behavior**
What actually happened.

**Environment**
- OS: [e.g. Windows 10, macOS 12.0, Ubuntu 20.04]
- PHP Version: [e.g. 8.1.0]
- Laravel Version: [e.g. 10.0.0]
- Browser: [e.g. Chrome 96.0]

**Additional Context**
Add any other context about the problem here.
\`\`\`

### Feature Request Template
\`\`\`markdown
**Feature Description**
A clear description of the feature you'd like to see.

**Use Case**
Explain why this feature would be useful.

**Proposed Solution**
Describe how you think this could be implemented.

**Alternatives Considered**
Any alternative solutions you've considered.

**Additional Context**
Add any other context or screenshots about the feature request.
\`\`\`

## 🏷️ Labels

We use the following labels to categorize issues:

- `bug` - Something isn't working
- `enhancement` - New feature or request
- `documentation` - Improvements to documentation
- `good first issue` - Good for newcomers
- `help wanted` - Extra attention is needed
- `priority: high` - High priority issues
- `priority: medium` - Medium priority issues
- `priority: low` - Low priority issues

## 🎯 Development Priorities

### High Priority
- Security vulnerabilities
- Critical bugs affecting core functionality
- Performance improvements

### Medium Priority
- New features
- UI/UX improvements
- Code refactoring

### Low Priority
- Documentation updates
- Minor bug fixes
- Code style improvements

## 📞 Getting Help

If you need help with contributing:

1. Check the [README.md](README.md) for setup instructions
2. Look through existing [issues](https://github.com/YOUR_USERNAME/task-management-system/issues)
3. Create a new issue with the "question" label
4. Join our community discussions

## 🙏 Recognition

Contributors will be recognized in:
- README.md contributors section
- Release notes for significant contributions
- GitHub contributors page

Thank you for helping make this project better! 🚀
