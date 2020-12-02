<template>
    <div class="rm-form rm-form--fluid" action="">
        <div class="rm-form__content">
            <div class="rm-form__content-fluid">
                <div class="rm-form__row">
                    <div class="row row--around-16 align-items-end">
                        <div class="col-12">
                            <div class="rm-form__field">
                                <div class="rm-form__field-label">
                                    Ваше имя
                                </div>
                                <div class="rm-form__field-options">
                                    <div class="rm-form__option">
                                        <input name="name" class="f-input" v-model="name">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="rm-form__field">
                                <div class="rm-form__field-label">
                                    Телефон
                                </div>
                                <div class="rm-form__field-options">
                                    <div class="rm-form__option">
                                        <input name="phone" id="phone-masked" required class="f-input" v-model="phone">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="rm-form__field">
                                <div class="rm-form__field-options rm-form__field-options--vertical rm-form__field-options--submit">
                                    <div class="rm-form__option rm-form__option--submit-button">
                                        <button v-on:click="sendForm"
                                                class="button button--type-main button--type-main-yellow
                                            ">
                                            Заказать звонок
                                            <span class="button__icon button__icon-loading"><span
                                                        class="loading">
                                            <span class="loading__item loading__item-1"></span>
                                            <span class="loading__item loading__item-2"></span>
                                            <span class="loading__item loading__item-3"></span>
                                        </span>
                                        </span>
                                            <span class="button__icon button__icon-success">
                                                    <svg class="button__icon-svg" width="24px"
                                                            height="24px">
                                                        <use xlink:href="svg-symbols.svg#success"></use>
                                                    </svg>
                                                </span>
                                            <span class="button__icon button__icon-error">
                                                    <svg class="button__icon-svg" width="24px"
                                                            height="24px">
                                                        <use xlink:href="svg-symbols.svg#error"></use>
                                                    </svg>
                                                </span>
                                        </button>
                                    </div>
                                    <div class="rm-form__option rm-form__option--vertical rm-form__option--submit-text">
                                        Нажимая на кнопку, вы соглашаетесь<br>условиями политики
                                        конфиденциальности
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Inputmask from 'inputmask';

    export default {
        name: "Form",
        props: {
            apartments: Array
        },
        data () {
            return {
                name: "",
                phone: "",
            }
        },
        methods: {
            sendForm(){
                let arFields = {
                    type: "feedback",
                    name: this.name,
                    phone: this.phone,
                }
                this.$emit("sendForm", arFields)
            }
        },
        mounted(){
            let inputMask = new Inputmask("+9 (999) 999-99-99");
            inputMask.mask(document.getElementById('phone-masked'));
        }
    }
</script>
