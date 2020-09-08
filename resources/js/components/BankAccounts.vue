<template>
    <v-layout align-start justify-sapce-between row fill-height  style="background: #4aa0e6">
        <v-flex >
            <v-btn dark color="green"> Nieuwe Rekening </v-btn>
            <v-btn dark color="green" > Terug </v-btn>
            <v-card v-for="a in accounts" :key="accounts.id" style="width:30%; height:100%; margin-left: 1%; margin-bottom: 1% ">
                <p class="text-sm-center">{{ a.balance}}</p>
                <p class="text-sm-center">{{ a.bank_number}}</p>
                <p class="text-sm-center">{{ a.bank_name}}</p>
                <v-list>
                    <v-list-tile>
                        <v-list-tile-content >
                            <v-container align-center justify-center row fill-height >
                                <v-btn @click="OpenEditPagePressed(p._id)">bewerken</v-btn>
                                <v-btn color="error" @click="deleteItem(p._id)">Wissen</v-btn>
                            </v-container>
                        </v-list-tile-content>
                    </v-list-tile>
                </v-list>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>

    export default {
        name: "BankAccounts",

        data() {
            return {
                accounts:[],
            }
        },
        methods:{

        },
        mounted() {
            window.axios.get('/getAccounts').then(response => {
                let temp = response.data;
                console.log(response.data);
                for(let i=0; i< temp.length;i++){
                    this.accounts.push({bank_id: temp[i].bank_id,user_id: temp[i].user_id , bank_number: temp[i].bank_number, bank_name: temp[i].bank_name, balance: temp[i].balance});
                }

            }).catch(function (error) {
                console.log(error);
            });
        }
    }
</script>

<style scoped>

</style>