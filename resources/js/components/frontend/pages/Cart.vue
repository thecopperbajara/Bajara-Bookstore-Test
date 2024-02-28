<template>
    <Default />
    <div class="container mx-auto mb-5">
        <div class="overflow-x-auto">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Cart Items</h2>
            </div>

            <table class="table table-bordered table-zebra">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Job</th>
                        <th>Favorite Color</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>1</th>
                        <td>Cy Ganderton</td>
                        <td>Quality Control Specialist</td>
                        <td>Blue</td>
                    </tr>
                    <tr>
                        <th>2</th>
                        <td>Hart Hagerty</td>
                        <td>Desktop Support Technician</td>
                        <td>Purple</td>
                    </tr>
                    <tr>
                        <th>3</th>
                        <td>Brice Swyre</td>
                        <td>Tax Accountant</td>
                        <td>Red</td>
                    </tr>
                    <tr>
                        <th>2</th>
                        <td>Hart Hagerty</td>
                        <td>Desktop Support Technician</td>
                        <td>Purple</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
        
    </div>
</template>

<script setup>
import Default from '../layouts/Default.vue';
</script>
