function enforceTouchTargets(root = document) {
  const elements = root.querySelectorAll('button, input, select, textarea, a.btn');
  elements.forEach((el) => {
    el.style.minWidth = '44px';
    el.style.minHeight = '44px';
  });
}

module.exports = { enforceTouchTargets };
