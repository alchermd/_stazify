<template>
    <input
        type="text"
        v-model="contactNumber"
        v-bind:maxlength="9"
        v-on:keypress="validateNumber"
    />
</template>

<script>
    export default {
        data() {
            return {
                contactNumber: null
            };
        },
        methods: {
            validateNumber(evt) {
                evt = evt ? evt : window.event;
                const charCode = evt.which ? evt.which : evt.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    evt.preventDefault();
                } else {
                    return true;
                }
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
