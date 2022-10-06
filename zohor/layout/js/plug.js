var cats=document.getElementsByClassName('cat_show'),
    len=cats.length;

cats[0].classList.add('active');
var m=document.getElementsByClassName(cats[0].textContent).length;
for(var x=0;x<m;x++){
   var el=document.getElementsByClassName(cats[0].textContent);
   el[x].style.display='';
}
/******start click  cats ***************/
   for(var i =0 ; i<len ;i++){
       cats[i].onclick=function(){
          for(var j =0 ; j<len ;j++){
            var m=document.getElementsByClassName(cats[j].textContent).length;
            for(var x=0;x<m;x++){
               var ele2=document.getElementsByClassName(cats[j].textContent);
               ele2[x].style.display='none';
               console.log(ele2[x]);
            }
          }
          for(var j =0 ; j<len ;j++){
            cats[j].classList.remove('active');
          }
          if(this.classList.contains('active') == false){
              this.classList.add('active');

              var l=document.getElementsByClassName(this.textContent).length;

              for(var x=0;x<l;x++){
                var ele=document.getElementsByClassName(this.textContent);
                ele[x].style.display='';
              }

          }
       }
   }
   /*  end click cats*/

   /***********Add to card******** */
   var items=document.getElementsByClassName('item_sel'),
       items_len=document.getElementsByClassName('item_sel').length;

       for(var k=0;k<items_len;k++){
          items[k].onclick=function(){
             var name=this.querySelector('h3').textContent,
                 price=this.querySelector('.price-tag').textContent,
                 empty_card=document.querySelector('.card_nocontent'),
                 new_card=document.querySelector('.card_content');

                 if(empty_card.hasAttribute('style')==false && new_card.hasAttribute('style')==true){
                  empty_card.style.display='none';
                  new_card.removeAttribute('style');
                      addItem(name,price);
                      add();
                      minus();
                      delet_item();
                      make_price(); 
                      
                  }else if(empty_card.hasAttribute('style')==true && new_card.hasAttribute('style')==false){
                      addItem(name,price);
                      add();
                      minus();
                      delet_item();
                      make_price();
                  }

          }
       }
       function addItem(type, price){
         var  new_item=document.createElement('p');
         var content_items=document.querySelector('.select_item'),
             items=content_items.getElementsByTagName('p'),
             l=items.length;
         
         console.log(items);
         console.log(l);
         var notvoid =false;
         if(l>0){
             
         for(var k=0;k<l;k++){
             
             var oldtype=items[k].getAttribute('content');
                 var numOfitem=items[k].getAttribute('value');
             //console.log(items[k]);
             if(type == oldtype){
                 //console.log(type,oldtype);
                 
                     var oldnum=parseInt(numOfitem,10)+1;
                 
                 items[k].setAttribute('value',oldnum);    
                 items[k].innerHTML='<button class="plus"> + </button>  '+oldnum+'  <button class="minus"> - </button> <span class="ctrl"> '+type+'    '+price*oldnum+' </span> <button class="clear"> x </button>';
                 
                 notvoid=false;
                 add();
                 minus();
                 delet_item();
                 make_price();
                 break;
                 
             }else if(type != oldtype){
                 notvoid =true;
             //show_total.appendChild(content_show_element); 
         
                 
                 //new_card.appendChild(show_total);
                 }
             
         }
         if(notvoid){
                 var num=1;
                 /*new_item_content=document.createTextNode(num+' '+type+'    '+price*num);
                 new_item.appendChild(new_item_content);*/
                 new_item.innerHTML='<button class="plus"> + </button>  '+num+'  <button class="minus"> - </button> <span class="ctrl"> '+type+'    '+price*num+' </span> <button class="clear"> x </button>' ;
                 new_item.setAttribute('content',type);
             new_item.setAttribute('value',num);
             content_items.appendChild(new_item);
            
             add();
             minus();
             delet_item();
             make_price();
                 }
             
         }else if(l===0){
             var num=1;
             /*var new_item_content=document.createTextNode(num+' '+type+'    '+price*num);
             new_item.appendChild(new_item_content);*/
             new_item.innerHTML='<button class="plus"> + </button>  '+num+'  <button class="minus"> - </button>  <span class="ctrl"> '+type+'    '+price*num+' </span> <button class="clear"> x </button>';
             new_item.setAttribute('content',type);
             new_item.setAttribute('value',num);
             content_items.appendChild(new_item);
             add();
             minus();
             delet_item();
             make_price();
         }
         
     }
    
     function make_price(){
      var minus_item=document.getElementsByClassName('minus'),
      addTotal=document.querySelector('.total'),
      totalval=document.querySelector('.input_total'),
      sum=0;
      
       if(minus_item.length==0){
         addTotal.innerHTML=sum;
       }
      for(var d=0;d<minus_item.length;d++){        
          
              
              var item_type2=minus_item[d].parentElement.getAttribute('content'),
                  item_value=minus_item[d].parentElement.getAttribute('value'),
                  
                  int_price,
                  item_price,
                  int_item_value,
                  itemAdd2=document.getElementsByClassName('item_sel'),
                  n=itemAdd2.length;
  
  
                 
                  for (var m=0;m<n;m++){ 
                      var type2=itemAdd2[m].querySelector('h3').textContent;
                      
                      if(type2==item_type2){
                          
                          var item_price2=itemAdd2[m].querySelector('.price-tag').textContent;
                          int_price=parseInt(item_price2,10);
                          int_item_value=parseInt(item_value,10);
                          item_price=int_price*int_item_value;
                          
                          break;
                      }
                      
                  }
                  
                
                  sum=item_price+sum;
                  
                  addTotal.innerHTML=sum;
                  totalval.setAttribute('value',sum);
          
      }   
      }      
      
      /*********************************plus minus******************************** */
      function add(){
         var add_item=document.getElementsByClassName('plus');
     console.log(add_item);

     for(var d=0;d<add_item.length;d++){        
         add_item[d].onclick=function(){
             
             var itemAdd=document.getElementsByClassName('item_sel'),
                 item_type2=this.parentElement.getAttribute('content'),
                 c=itemAdd.length;

                 for (var m=0;m<c;m++){ 
                     var type=itemAdd[m].querySelector('h3').textContent;
                     if(type==item_type2){
                         item_price2=itemAdd[m].querySelector('.price-tag').textContent;
                         addItem(item_type2,item_price2);
                         make_price();
                     }
                 }
         }  
     }
     }

     function minus(){
         var minus_item=document.getElementsByClassName('minus');


     for(var d=0;d<minus_item.length;d++){        
         minus_item[d].onclick=function(){
             
             var itemAdd=document.getElementsByClassName('item_sel'),
                 item_type2=this.parentElement.getAttribute('content'),
                 c=itemAdd.length;

                 for (var m=0;m<c;m++){ 
                     var type=itemAdd[m].querySelector('h3').textContent;
                     if(type==item_type2){
                         item_price2=itemAdd[m].querySelector('.price-tag').textContent;
                         minusItem(item_type2,item_price2);
                         make_price();
                     }
                 }
         }  
     }
     }

     function delet_item(){
         var delet_item=document.getElementsByClassName('clear');


     for(var e=0;e<delet_item.length;e++){        
         delet_item[e].onclick=function(){
             
             var item_type2=this.parentElement.getAttribute('content');
             remove(item_type2);
             make_price();
         }  
     }
     }


     function minusItem(type,price){
         var content_items=document.querySelector('.select_item'),
     items=content_items.getElementsByTagName('p'),
     l=items.length;



     for(var k=0;k<l;k++){
     
     var oldtype=items[k].getAttribute('content');
         var numOfitem=items[k].getAttribute('value');
     //console.log(items[k]);
     if(type == oldtype){
         //console.log(type,oldtype);
         
             var oldnum=parseInt(numOfitem,10)-1;
             if(oldnum==0){
             
             items[k].setAttribute('value',oldnum);    
         items[k].innerHTML='<button class="plus"> + </button>  '+oldnum+'  <button class="minus"> - </button> <span class="ctrl"> '+type+'    '+price*oldnum+' </span><button class="clear"> x </button>';
         
         add();
         minus();
         delet_item();
         make_price();
         remove(type);
         break;
             }else{
             
         items[k].setAttribute('value',oldnum);    
         items[k].innerHTML='<button class="plus"> + </button>  '+oldnum+'  <button class="minus"> - </button> <span class="ctrl"> '+type+'    '+price*oldnum+' </span><button class="clear"> x </button>';
         
         add();
         minus();
         delet_item();
         make_price();
         break;
             }
     }
     }
     }


     /**********
     * 
     * ****** */
     function remove(type){
         var content_items=document.querySelector('.select_item'),
     items=content_items.getElementsByTagName('p'),
     l=items.length;



     for(var k=0;k<l;k++){
     
     var select_type=items[k].getAttribute('content');
         
     if(type == select_type){
             
         items[k].remove();
         
         add();
         minus();
         delet_item();
         make_price();
         break;
         
     }
     }
     }


/**************end add to card******* */
/****************on click on paid button */
var paid_btn=document.querySelector('.paid'),
    not_paid_btn=document.querySelector('.not_paid'),
    input_content=document.querySelector('.input_content');
paid_btn.onclick=function(){
    var select_item=document.querySelector('.select_item').getElementsByTagName('p'),
      select_item_len=select_item.length,
      val='';

      for(var a=0 ;a<select_item_len;a++){
          var type=select_item[a].getAttribute('content'),
              num=select_item[a].getAttribute('value');
              val=val+num+'-'+type+'-';
              input_content.setAttribute('value',val);
      }

}
not_paid_btn.onclick=function(){
    var select_item=document.querySelector('.select_item').getElementsByTagName('p'),
      select_item_len=select_item.length,
      val='';

      for(var a=0 ;a<select_item_len;a++){
          var type=select_item[a].getAttribute('content'),
              num=select_item[a].getAttribute('value');
              val=val+num+'-'+type+'-';
              input_content.setAttribute('value',val);
      }

}
/*******************end on click on paid button */