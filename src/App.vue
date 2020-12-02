<template>
    <div id="feedback-form" class="section" :class="{ 'active' : loading}">
            <SVGSymbols/>
            <div class="section__body">
                <Form v-on:sendForm="onSendForm"/>
            </div>
    </div>
</template>

<script>
    import {
        mapActions,
        mapState
    } from 'vuex'
    import SVGSymbols from './components/SVGSymbols.vue'
    import Form from './components/Form.vue'

    export default {
        name: 'App',
        components: {
            SVGSymbols,
            Form
        },

        computed: {
            ...mapState([
                'loading',
                'errors',
            ]),
        },

        methods: {
            ...mapActions([
                'sendForm'
            ]),
            onSendForm: function (arFields) {
                this.sendForm(arFields)
            }
        },
    }
</script>

<style lang="scss">
    #feedback-form {
        transition: opacity ease-in-out 300ms;
    }

    #feedback-form.active{
        opacity: .6;
        pointer-events: none;
    }
</style>
