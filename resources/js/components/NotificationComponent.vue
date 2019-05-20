<template>
    <div class="notification alert" role="alert"
         v-bind:class="{ 'alert-success': result.success, 'alert-danger': result.errors }">
        <span>{{message}}</span>
        <button type="button" class="close px-2" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</template>

<script>
    export default {
        props: [
            'results'
        ],
        data() {
            return {
                message: '',
                result: {
                    errors: false,
                    success: false,
                    data: {},
                }
            }
        },
        beforeMount() {

            if(this.results.errors.length !== 0){

                this.result.data = this.results;
                this.result.errors = true;

                if(this.result.data.results.freePlaces !== 0){
                    this.message = 'Sorry, there are only ' + this.result.data.results.freePlaces + ' more available spots for this workshop.'
                }else {
                    this.message = 'Sorry, there are have not more available spots for this workshop.'
                }

            }else if(this.results.results.length !== 0){
                this.result.data = this.results;
                this.result.success = true;
                this.message = 'Workshop booked. Thanks for registering in workshop.';
            }

        }
    }
</script>
