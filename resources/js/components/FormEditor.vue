<template>
    <default-field :field="field" :errors="errors" :full-width-content="true">
        <template slot="field">
                <vue-editor v-model="value" :id="vue-editor" useCustomImageHandler @imageAdded="handleImageAdded">
                </vue-editor>
                <!-- 这段主要为了给表单提交 -->
                <input :id="field.attribute" type="hidden" class="w-full form-control form-input form-input-bordered" :class="errorClasses" :placeholder="field.attribute" v-model="value" />
        </template>
    </default-field>
</template>
<script>
import { VueEditor } from "vue2-editor";
import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
    mixins: [FormField, HandlesValidationErrors],

    components: {
        VueEditor
    },

    props: ['resourceName', 'resourceId', 'field'],

    methods: {
        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.value = this.field.value || ''
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            formData.append(this.field.attribute, this.value || '')
        },

        /**
         * Update the field's internal value.
         */
        handleChange(value) {
            this.value = value
        },

        handleImageAdded: function(file, Editor, cursorLocation, resetUploader) {
            var formData = new FormData();
            formData.append('image', file)
            Nova.request({
                url: '/nova-vendor/vue-editor/upload-image',
                method: 'POST',
                data: formData
            }).then((result) => {
                let url = result.data.url // Get url from response
                Editor.insertEmbed(cursorLocation, 'image', url);
                resetUploader();
            }).catch((err) => {
                console.log(err);
            })
        }
    },
}

</script>