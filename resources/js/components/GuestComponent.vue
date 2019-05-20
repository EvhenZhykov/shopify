<template>
    <div class="guest-block border-top py-3">
        <button type="button" class="close" @click="remove" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">Guest Name</label>
            <div class="col-sm-6">
                <input type="text"
                       class="form-control"
                       name="name"
                       placeholder="Guest Name"
                       v-model="guest.name"
                       v-bind:class="{ 'is-invalid': validationError[guestIndex] && validationError[guestIndex].name }">
                <div class="invalid-feedback"
                     v-if="validationError[guestIndex] && validationError[guestIndex].name">
                    {{ validationError[guestIndex].name[0] }}
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-6">
                <input type="email"
                       class="form-control"
                       name="email"
                       placeholder="Email"
                       v-model="guest.email"
                       v-bind:class="{ 'is-invalid': validationError[guestIndex] && validationError[guestIndex].email }">
                <div class="invalid-feedback"
                     v-if="validationError[guestIndex] && validationError[guestIndex].email">
                    {{ validationError[guestIndex].email[0] }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'guest',
            'guestIndex',
            'validationError'
        ],
        methods: {
            remove() {
                this.$emit('removeGuest', this.guestIndex);
            }
        }
    }
</script>
