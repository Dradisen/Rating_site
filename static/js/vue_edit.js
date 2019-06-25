if(document.getElementById('worker_field') != null ){
    var name_default = document.getElementById('worker_field').value;
    var position_default = document.getElementById('position_field').value;

    new Vue({
        el: "#workers-form",
        data:{
            errors: [],
            name: name_default,
            position: position_default,
    
        },
        methods:{
            checkForm: function(e){
                this.errors = [];
    
                if(this.name == ""){ 
                    this.errors.push("Не добавлено имя");
                }
                if(this.position == ""){ 
                    this.errors.push("Не добавлена позиция");
                }
    
                if(!this.errors.length){
                    return true;
                }
    
                e.preventDefault();
            }
        },
    
    })

}else{
    var name_default = document.getElementById('rating').value;
    new Vue({
        el: "#rating-form",
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
}
