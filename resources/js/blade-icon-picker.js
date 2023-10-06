import IconPickerField from './fieldtypes/IconPicker.vue';

Statamic.booting(() => {
    Statamic.$components.register('icon_picker-fieldtype', IconPickerField);
});
