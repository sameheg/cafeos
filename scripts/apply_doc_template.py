#!/usr/bin/env python3
import pathlib

TEMPLATE_PATH = pathlib.Path('DOC_TEMPLATE.md')
SECTIONS = [line.strip() for line in TEMPLATE_PATH.read_text().splitlines() if line.startswith('##')]
TEMPLATE_LINES = TEMPLATE_PATH.read_text().splitlines()

def needs_template(lines):
    return not all(any(line.startswith(section) for line in lines) for section in SECTIONS)

def apply_template(path):
    lines = path.read_text().splitlines()
    if lines and lines[0].startswith('#'):
        title = lines[0]
        content = lines[1:]
    else:
        title = f"# {path.stem.replace('_', ' ').title()}"
        content = lines
    new_lines = [title, '']
    new_lines.extend(TEMPLATE_LINES)
    new_lines.append('')
    new_lines.extend(content)
    path.write_text('\n'.join(new_lines) + '\n')

for md_file in pathlib.Path('.').glob('*.md'):
    if md_file.name == 'DOC_TEMPLATE.md':
        continue
    lines = md_file.read_text().splitlines()
    if needs_template(lines):
        apply_template(md_file)

# Last Updated: 2025-09-11 by ChatGPT
