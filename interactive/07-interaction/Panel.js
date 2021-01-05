class Panel{
    constructor(){
        this.scale = 0;
        this.angle = 0;
    }

    draw(){
        ctx.fillStyle = 'rgba(180, 100, 0, 0.8';
        // 변환 초기화;
        ctx.resetTransform();
        // ctx.setTransform(1,0,0,1,0,0);
        ctx.translate(oX, oY);
        ctx.scale(this.scale, this.scale);
        ctx.rotate(canUtil.toRadian(this.angle));
        ctx.translate(-oX, -oY);
        ctx.fillRect(oX-150, oY-150, 300, 300);
        ctx.resetTransform();
    }

    showContent() {
        // console.log('showContent 실행');
        ctx.fillStyle = '#fff';
        ctx.fillText(selectedBox.index+1, oX, oY);
    }
}