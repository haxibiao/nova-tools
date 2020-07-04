<template>
    <default-field :field="field" :errors="errors">
        <template slot="field">
            <multiselect
              name="tag"
              v-model="selected"
              :options="options"
              :multiple="true"
              :taggable="true"
              @close="syncValue"
              tag-placeholder="新建标签"
              placeholder="请输入您的标签"
              label="name"
              track-by="tag_id"
              @onblur="test"
              :style="{height:height}">
            </multiselect>
        </template>
    </default-field>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'
import Multiselect from 'vue-multiselect'

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    components: { Multiselect },

    mounted:function()
    {
        if(this.field.options){
            this.options = JSON.parse(this.field.options);
        }

        if(this.value){
            this.selected = JSON.parse(this.value);
        }
    },

    data () {
      return {
        selected:null,
        options:[],
        height: 'height' in this.field ? this.field.height+'px' : 'auto'
      }
    },

    watch:{
      selected:function(){
        this.syncValue();
      }
    },

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

        addTag (newTag) {
          var tag = {
            name: newTag,
            tag_id:null,
          };
          var vm = this;
          vm.options.push(tag);
          vm.selected.push(tag);
        },

        syncValue () {
            this.value = JSON.stringify(this.selected);
        }
    },
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>


