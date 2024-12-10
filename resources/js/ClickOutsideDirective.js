export const ClickOutside = {
    beforeMount(el, binding) {
        el.__ClickOutsideHandler__ = (event) => {
            if (!(el === event.target || el.contains(event.target))) {
                binding.value(event);
            }
        };
        document.addEventListener('click', el.__ClickOutsideHandler__);
    },
    unmounted(el) {
        document.removeEventListener('click', el.__ClickOutsideHandler__);
        el.__ClickOutsideHandler__ = null;
    },
};
