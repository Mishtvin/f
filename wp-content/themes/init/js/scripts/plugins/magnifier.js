// by Antonis-Ntit
const Style=
{
  circle:'50',square:'0'
}

//---
class Magnifier
{
 
    constructor(elem=null)
    {
        console.log("Magnifier class OK. Element id:"+elem.id);      
        this.color='#aaaaaa';            
        this._size=150;// Default Size
        this.glassDiv=null;
        this.zoomFct=2; // default 2
        this.isCliped=false;
        this.stroke=3;
        this.sourcTop=0;        
        this.sourcLeft=0;
        this.sourcElem=elem;
        this.style=Style.circle;             
        this.show=false;        
        this.ctx=null;
        setTimeout(function () // Wait 50 mSec for scroll top left 0,0
        {
          window.scrollTo(0, 0);
          this.init()
        }.bind(this),50);        
             
    }
    //---
    init()
    {     
       if(this.zoomFct<=1){this.zoomFct=1;}       
       if( this.sourcElem )
       {       
         this.mouseEvents(this.sourcElem);
         this.sourcTop=this.sourcElem.getBoundingClientRect().top;
         this.sourcLeft=this.sourcElem.getBoundingClientRect().left;
         this.getGlassDiv(this.sourcElem);      
         this.showMagnifier();       
        }           
     } 

    //---
    getGlassDiv(imgSrc)
    {      
      this.glassDiv=null;
      this.glassDiv=document.createElement("div");  
      this.glassDiv.id="glass_"+this.sourcElem.id;
      this.mouseEvents(this.glassDiv);     
      this.glassDivStyle();  
      this.glassDiv.style.backgroundImage='url('+imgSrc.src+')' ;    
      document.body.appendChild(this.glassDiv);  
          
    }     

    //---
    glassDivStyle()
    {
      if(!this.glassDiv){return}
      this.glassDiv.style.backgroundRepeat='no-repeat';     
      this.glassDiv.style.width=this.Size+"px";
      this.glassDiv.style.height=this.Size+"px";
      this.glassDiv.style.border =''+this.stroke+'px solid '+this.color;
      this.glassDiv.style.borderRadius= this.Style+ '%';
      this.glassDiv.style.position='absolute';
      this.glassDiv.style.top=this.sourcTop +"px";
      this.glassDiv.style.left=this.sourcLeft+"px";      
    }
        
   
    //---
    moveGlassDiv(mX,mY)
    {              
      let offset=4;let x,y;   
      let zoomX=this.sourcElem.width*this.zoomFct;
      let zoomY=this.sourcElem.height*this.zoomFct;              
      if(this.zoomFct>1)
      {           
        offset =(this.Size*this.zoomFct)/2 - (this.Size/2);   
        offset-=4*this.zoomFct; 
      };         
      x = ( ( -mX-this.zoomFct )*this.zoomFct) - offset;
      y = ( ( -mY-this.zoomFct )*this.zoomFct) - offset;      
      if( mX+(this.Size/2)>this.sourcElem.width-(this.Size/4)/this.zoomFct ||
          mX+(this.Size/2)<=(this.Size/4)/this.zoomFct ||
          mY+(this.Size/2)>this.sourcElem.height-(this.Size/4)/this.zoomFct ||
          mY+(this.Size/2)<=8 
        ){return}
      
      this.glassDiv.style.backgroundSize=zoomX+"px "+ zoomY+"px"; 
      this.glassDiv.style.left=mX+this.sourcLeft+"px";
      this.glassDiv.style.top=mY+this.sourcTop+"px";   
      this.glassDiv.style.backgroundPositionX=x +'px';
      this.glassDiv.style.backgroundPositionY=y +'px'; 
                      
    }  
    
    //---
    mouseEvents(elem)
    {
     elem.onclick=function(e){this.onClick(e)}.bind(this);   
     elem.onmousemove=function(e){ this.onMouseMove(e)}.bind(this) ;      
    } 
    
    //---
    onClick(e)
    {         
     this.showMagnifier();
    }  

    //---
    onMouseMove(e)
    {          
      let y=e.clientY-(this.Size/2)-this.sourcTop;
      y+=window.scrollY;
      let x=e.clientX-(this.Size/2)-this.sourcLeft;
      x+=window.scrollX;    
      if(this.glassDiv) {this.moveGlassDiv(x,y);}                 
    }
   
    //---
    showMagnifier()
    {
     if(this.glassDiv)
     {      
       this.glassDiv.style.visibility= this.show ?'visible':'hidden';     
       this.glassDiv.style.cursor= 'none';
       this.sourcElem.style.cursor='zoom-in';
       this.show=!this.show      
     }
    }

  
    // Zoom factor
    set Zoom(value)
    {
      if(value<=1){value=1;}
      this.zoomFct=value;
    }
    
    //---
    set StrokeColor(color)
    {
      this.color=color;
      this.glassDivStyle();
    }

    //---
    set Stroke(value)
    {
      if(value>5){value=5;} 
      else if(value<0){value=0;}     
      this.stroke=value;
      this.glassDivStyle();
    }


    //---
    set Size(size)
    {
      if(size<1){size=1;}
      this._size=size;
      this.glassDivStyle();     
    }

    //---
    get Size()
    {
      return this._size;
    }   

    //---
    set Style(stl)
    {
       this.style=stl;
       if(this.style==undefined){ this.style=Style.circle }    
       this.glassDivStyle();
    }

    //---
    get Style()
    {
      return this.style;
    }
   
}



