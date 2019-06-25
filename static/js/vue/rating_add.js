var name_default = document.getElementById('rating').value;

new Vue({
    el: "#form",
    data:{
        message: name_default,
        errors: [],
        check: null,
    },
    methods:{
        checkForm: function(e){
            this.errors = [];

            if(this.message == ""){ 
                this.errors.push("Не добавлен рейтинг");
            }

            if(!this.errors.length){
                return true;
            }

            e.preventDefault();
        },
    },
    watch: {
        message: function(){
            for(var i = 0; i < this.message.length; i++){
                if(!isNaN(this.message) || this.message == ""){
                    this.check = null;
                }else{
                    this.check = "Введите число!";
                }
            }
        }
    }

})