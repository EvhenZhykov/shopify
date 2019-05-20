<template>
    <div class="row workshop-block">
        <div v-if="results.results || results.errors">
            <notification :results ="results"></notification>
        </div>
        <div class="col-md-6 offset-md-3 text-center border p-3">
            <h2>Please, fill out the form</h2>
        </div>
        <div class="col-md-6 offset-md-3 border border-top-0 p-3">
            <form v-on:submit.prevent="submit">
                <div class="form-group row">
                    <label for="customerName" class="col-sm-3 col-form-label">Customer Name</label>
                    <div class="col-sm-6">
                        <input type="text"
                               class="form-control"
                               id="customerName"
                               name="name"
                               placeholder="Customer Name"
                               v-model="fields.name"
                               v-bind:class="{ 'is-invalid': validationError.customer.name }">
                        <div class="invalid-feedback"
                             v-if="validationError && validationError.customer.name">
                            {{ validationError.customer.name[0] }}
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="phone" class="col-sm-3 col-form-label">Phone</label>
                    <div class="col-sm-6">
                        <input type="text"
                               class="form-control"
                               id="phone"
                               name="phone"
                               placeholder="Phone"
                               v-model="fields.phone"
                               v-bind:class="{ 'is-invalid': validationError.customer.phone }">
                        <div class="invalid-feedback"
                             v-if="validationError && validationError.customer.phone">
                            {{ validationError.customer.phone[0] }}
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="workshopId" class="col-sm-3 col-form-label">Workshop Time</label>
                    <div class="col-sm-6">
                        <select id="workshopId"
                                class="form-control"
                                name="workshopId"
                                v-model="fields.workshopId"
                                v-bind:class="{ 'is-invalid': validationError.customer.workshopId }">
                            <option v-for="option in options"
                                    v-html="option.time"
                                    v-bind:value="option.id">
                            </option>
                        </select>
                        <div class="invalid-feedback"
                             v-if="validationError && validationError.customer.workshopId">
                            {{ validationError.customer.workshopId[0] }}
                        </div>
                    </div>
                </div>
                <div v-for="(guest, index) in fields.guests">
                    <guest v-bind:guest="guest"
                           :guestIndex="index"
                           :validationError="validationError.guests"
                           @removeGuest="removeGuest">
                    </guest>
                </div>
                <div class="text-right py-3">
                    <button type="button" class="btn btn-primary" v-on:click="addGuest">Add guest</button>
                </div>
                <div class="col-md-12 text-right border-top py-3 px-0">
                    <button type="submit" class="btn btn-primary">Book Workshop</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        data() {
            return {
                fields: {
                    name: '',
                    phone: '',
                    workshopId: '',
                    guests : []
                },
                results: {},
                options: {},
                validationError: {
                    customer: {
                        name:'',
                        phone:'',
                        workshopId:'',
                    },
                    guests: {
                        name: '',
                        email: ''
                    }
                }
            }
        },
        methods: {
            submit() {
                this.results = {};
                axios.post('/booking', this.fields).then(response => {
                    this.results = response.data  || {};
                    this.fields = {
                        name: '',
                        phone: '',
                        workshopId: '',
                        guests : []
                    };
                    this.validationError = {
                        customer: {
                            name:'',
                            phone:'',
                            workshopId:'',
                        },
                        guests: {
                            name: '',
                            email: ''
                        }
                    }
                }).catch(error => {
                    if (error.response.status === 400) {
                        if(error.response.data.errors.error){
                            this.results = error.response.data || {};
                            this.validationError.guests = {};
                            this.validationError.customer = {};
                        }else {
                            if(error.response.data.errors.guests){
                                this.validationError.guests = error.response.data.errors.guests;
                            }
                            if(error.response.data.errors.customer){
                                this.validationError.customer = error.response.data.errors.customer;
                            }
                        }
                    }
                });
            },
            addGuest() {
                this.fields.guests.push({
                        name: '',
                        email: ''
                    });
            },
            removeGuest(index) {
                this.fields.guests.splice(index, 1);
            }
        },
        beforeMount() {
            axios.get('/get-initial-data').then(response => {
                this.options = response.data.results.workshops;

            }).catch(error => {
                if (error.response.status === 422) {
                    this.results = error.response.data || {};
                }
            });
        }
    }
</script>
