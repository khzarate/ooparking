<template>
    <div class="grid grid-cols-2 mb-4">
        <div class="px-8 py-4 text-center">
            <app-button bgColor="green" class="text-xl" @click="parkForm=!parkForm; unparkForm = false; input = {};">Park</app-button>
        </div>
        <div class="px-8 py-4 text-center">
            <app-button bgColor="red" class="text-xl" @click="unparkForm=!unparkForm; parkForm = false; input = {};">Unpark</app-button>
        </div>
    </div>
    <div v-show="parkForm" class="grid grid-cols-1">
        <h1 class="text-center text-xl">Park Vehicle</h1>
        <div class="px-8 py-4">
            <label for="plateNumber" class="form-label inline-block mb-2 text-gray-700"
            >Vehicle Plate Number</label>
            <input
            v-model="input.plate_number"
            type="text"
            class="
                form-control
                block
                w-full
                px-3
                py-1.5
                text-base
                font-normal
                text-gray-700
                bg-white bg-clip-padding
                border border-solid border-gray-300
                rounded
                transition
                ease-in-out
                m-0
                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none
            "
            id="plateNumber"
            placeholder="Vehicle plate number"
            />
            <yupValidationError :error="errors.plate_number"/>
        </div>
        <div class="px-8 py-4">
            <label for="plateNumber" class="form-label inline-block mb-2 text-gray-700"
            >Vehicle Type</label>
            <select class="form-select appearance-none
            block
            w-full
            px-3
            py-1.5
            text-base
            font-normal
            text-gray-700
            bg-white bg-clip-padding bg-no-repeat
            border border-solid border-gray-300
            rounded
            transition
            ease-in-out
            m-0
            focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" aria-label="Default select example" v-model="input.vehicle_type">
                <option selected>Select Vehicle Type</option>
                <option v-for="type in vehicleTypeOptions" :key="type.id" :value="type.value">{{ type.label }}</option>
            </select>
            <yupValidationError :error="errors.vehicle_type"/>
        </div>
        <div class="px-8 py-4">
            <label for="plateNumber" class="form-label inline-block mb-2 text-gray-700"
            >Entry Point</label>
            <select class="form-select appearance-none
            block
            w-full
            px-3
            py-1.5
            text-base
            font-normal
            text-gray-700
            bg-white bg-clip-padding bg-no-repeat
            border border-solid border-gray-300
            rounded
            transition
            ease-in-out
            m-0
            focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" aria-label="Default select example" v-model="input.entry_point">
                <option selected>Select Entry Point</option>
                <option v-for="type in entryExitPointsOptions" :key="type.id" :value="type.value">{{ type.label }}</option>
            </select>
            <yupValidationError :error="errors.entry_point"/>
        </div>
        <div class="px-8 py-4">
            <label for="timeIn" class="form-label inline-block mb-2 text-gray-700"
            >Time In</label>
            <Datepicker v-model="input.time_in" :is24="false"></Datepicker> 
            <yupValidationError :error="errors.time_in"/>
        </div>

        <div class="px-8 py-4">
            <app-button bgColor="green" @click="parkVehicle">
                Park Vehicle
            </app-button>
        </div>
    </div>

    <div v-show="unparkForm" class="grid grid-cols-1">
        <h1 class="text-center text-xl">Unpark Vehicle</h1>
        <div class="px-8 py-4">
            <label for="plateNumber" class="form-label inline-block mb-2 text-gray-700"
            >Vehicle Plate Number</label>
            <input
            v-model="input.plate_number"
            type="text"
            class="
                form-control
                block
                w-full
                px-3
                py-1.5
                text-base
                font-normal
                text-gray-700
                bg-white bg-clip-padding
                border border-solid border-gray-300
                rounded
                transition
                ease-in-out
                m-0
                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none
            "
            id="plateNumber"
            placeholder="Vehicle plate number"
            />
            <yupValidationError :error="errors.plate_number"/>
        </div>
        <div class="px-8 py-4">
            <label for="plateNumber" class="form-label inline-block mb-2 text-gray-700"
            >Exit Point</label>
            <select class="form-select appearance-none
            block
            w-full
            px-3
            py-1.5
            text-base
            font-normal
            text-gray-700
            bg-white bg-clip-padding bg-no-repeat
            border border-solid border-gray-300
            rounded
            transition
            ease-in-out
            m-0
            focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" aria-label="Default select example" v-model="input.exit_point">
                <option selected>Select Entry Point</option>
                <option v-for="type in entryExitPointsOptions" :key="type.id" :value="type.value">{{ type.label }}</option>
            </select>
            <yupValidationError :error="errors.exit_point"/>
        </div>
        <div class="px-8 py-4">
            <label for="timeOut" class="form-label inline-block mb-2 text-gray-700"
            >Time Out</label>
            <Datepicker v-model="input.time_out" :is24="false"></Datepicker> 
            <yupValidationError :error="errors.time_out"/>
        </div>

        <div class="px-8 py-4">
            <app-button bgColor="green" @click="unparkVehicle">
                Unpark Vehicle
            </app-button>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';

    import AppButton from "../Components/Button";
    import yupValidationError from "../Components/yupValidationError";

    import useAsync from "../composables/useAsync";
    import useYup from '../composables/useYup';
    import { parkVehicleSchema } from '../schema/parkVehicleSchema'
    import { unparkVehicleSchema } from '../schema/unparkVehicleSchema'


    import parkingServices from "../services/parkingServices";
    import Swal from "sweetalert2";
    import Datepicker  from "@vuepic/vue-datepicker";
    import '@vuepic/vue-datepicker/dist/main.css';

    import dayjs from "dayjs";
 
    export default {
        components: {
            axios,
            AppButton,
            Datepicker,
            yupValidationError
        },
        props: [

        ],
        
        data () {
            return {
                input: {},
                vehicleTypeOptions: [
                    {
                        value: 'S',
                        label: 'Small'
                    },
                    {
                        value: 'M',
                        label: 'Medium'
                    },
                    {
                        value: 'L',
                        label: 'Large'
                    }
                ],
                entryExitPointsOptions: [
                    {
                        value: '1',
                        label: 'Gate 1'
                    },
                    {
                        value: '2',
                        label: 'Gate 2'
                    },
                    {
                        value: '3',
                        label: 'Gate 3'
                    }
                ],
                parkForm: true,
                unparkForm: false,
                errors: {},
            }

        },
        mounted() {

        },
        methods: {
            async parkVehicle(){
                this.errors = await useYup(parkVehicleSchema, {...this.input});
                if(!Object.entries(this.errors).length) {
                    const payload = {
                        plate_number: this.input.plate_number,
                        vehicle_type: this.input.vehicle_type,
                        entry_point: this.input.entry_point,
                        time_in: dayjs(this.input.time_in).format('YYYY-MM-DD HH:mm:ss')
                    }
                    const { response } = await useAsync(
                        parkingServices.parkVehicle(payload)
                    );
                    console.log(response);  
                    if(response.status == 200){
                        Swal.fire({
                            icon: 'success',
                            title: response.data.message,
                            html: response.data.text,
                            didClose: () => {
                                this.input = {};
                            }
                        });
                    } else if(response.status == 202){
                        Swal.fire({
                            icon: 'warning',
                            title: response.data.message,
                            html: response.data.text
                        });
                    }
                }
            },
            async unparkVehicle(){
                this.errors = await useYup(unparkVehicleSchema, {...this.input});

                if(!Object.entries(this.errors).length) {
                    const payload = {
                        plate_number: this.input.plate_number,
                        exit_point: this.input.exit_point,
                        time_out: dayjs(this.input.time_out).format('YYYY-MM-DD HH:mm:ss')
                    }
    
                    const { response } = await useAsync(parkingServices.unparkVehicle(payload))
                    if(response.status == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: response.data.message,
                            html: response.data.text,
                            didClose: () => {
                                this.input = {};
                            }
                        });
                    } else if(response.status == 202) {
                        Swal.fire({
                            icon: 'warning',
                            title: response.data.message,
                            html: response.data.text
                        });
                    }
                }
            }
        },
    }
</script>