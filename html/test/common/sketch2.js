let score =100;
let cutpoint = 2;
let changepoint = 2;
// let vanishpoint = 1;
// let vanishpoint;
// let param = JSON.parse('<?php echo $aaa_json; ?>');
// console.log(param);
// let vanishpoint = param;

new p5();


// vanishpoint = Number(vanishpoint);


class Block {
    constructor(x,y) {
        this.x = x;
        this.y = y;
    }
    draw() {
        push();
        let s = 25;
        // rect(s*this.x, s*this.y,s,s);
        rect(s*this.x, s*this.y,s,s);
        pop();
    }
}

class Mino {
    constructor(x,y,rot,shape,color) {
        this.x = x;
        this.y = y;
        this.rot = rot;
        this.shape = shape;
        this.color = color;
    }
    calcBlocks() {
        let blocks= [];
        switch(this.shape) {
            case 0: blocks = [new Block(-1,0), new Block(0,0), new Block(0,-1), new Block(1,0)];break; //T
            case 1: blocks = [new Block(-1,-1), new Block(0,-1), new Block(0,0), new Block(1,0)];break; //Z
            case 2: blocks = [new Block(-1,0), new Block(0,0), new Block(0,-1), new Block(1,-1)];break; //S
            case 3: blocks = [new Block(-1,-2), new Block(-1,-1), new Block(-1,0), new Block(0,0)];break; //L
            case 4: blocks = [new Block(0,-2), new Block(0,-1), new Block(-1,0), new Block(0,0)];break; //J
            case 5: blocks = [new Block(-1,-1), new Block(-1,0), new Block(0,0), new Block(0,-1)];break; //O
            case 6: blocks = [new Block(-2,0), new Block(-1,0), new Block(0,0), new Block(1,0)];break; //I
        }
        let rot = (4e7 + this.rot) % 4;
        for(let r=0; r<rot; r++) {
            // rotate 90 
            // blocks.forEach(b => (b.x=-b.y, b.y=b.x));
            blocks = blocks.map(b => new Block(-b.y, b.x));
        }
        blocks.forEach(b => (b.x+=this.x, b.y+=this.y));
        return blocks;
    }
    draw() {
        let blocks = this.calcBlocks();

        for(let b of blocks) {
            b.draw();
            
        }
    }
    copy() {
        return new Mino(this.x, this.y, this.rot, this.shape);
    }
}

class Field {
    constructor() {
        this.tiles = [
            [1,0,0,0,0,0,0,0,0,0,0,1],
            [1,0,0,0,0,0,0,0,0,0,0,1],
            [1,0,0,0,0,0,0,0,0,0,0,1],
            [1,0,0,0,0,0,0,0,0,0,0,1],
            [1,0,0,0,0,0,0,0,0,0,0,1],
            [1,0,0,0,0,0,0,0,0,0,0,1],
            [1,0,0,0,0,0,0,0,0,0,0,1],
            [1,0,0,0,0,0,0,0,0,0,0,1],
            [1,0,0,0,0,0,0,0,0,0,0,1],
            [1,0,0,0,0,0,0,0,0,0,0,1],
            [1,0,0,0,0,0,0,0,0,0,0,1],
            [1,0,0,0,0,0,0,0,0,0,0,1],
            [1,0,0,0,0,0,0,0,0,0,0,1],
            [1,0,0,0,0,0,0,0,0,0,0,1],
            [1,0,0,0,0,0,0,0,0,0,0,1],
            [1,0,0,0,0,0,0,0,0,0,0,1],
            [1,0,0,0,0,0,0,0,0,0,0,1],
            [1,0,0,0,0,0,0,0,0,0,0,1],
            [1,0,0,0,0,0,0,0,0,0,0,1],
            [1,0,0,0,0,0,0,0,0,0,0,1],
            [1,1,1,1,1,1,1,1,1,1,1,1],
        ];
    }
    tilesAt(x,y) {
        if(x<0 || x>=12 || y<0 || y>=21) return 1;
        return this.tiles[y][x];
    }
    putBlock(x, y) {
        this.tiles[y][x] = 1;
    }
    findLineFilled() {
        for(let y=0; y<20; y++) {
            let isFilled = this.tiles[y].every(t => t===1);
            if (isFilled) return y;
        }
        return -1;
    }
    cutLine(y) {
        this.tiles.splice(y, 1);
        this.tiles.unshift([1,0,0,0,0,0,0,0,0,0,0,1]);
    }
    draw() {
        for(let y=0; y<21; y++) {
            for(let x=0; x<12; x++) {
                if (this.tilesAt(x,y) === 0) continue;
                new Block(x,y).draw();
            }
        }
    }
}


class Game {
    constructor() {
        this.mino = Game.makeMino();
        this.minoVx = 0;
        this.minoDrop = false;

        this.minoVr = 0;
        this.field = new Field();
        this.fc = 0;
    }
    static makeMino() {
        // return new Mino(6, 2, 0, 5);
        // let Color = floor(random(0,7));
        // return new Mino(5, 1, 0, Color, Color);
        return new Mino(5, 1, 0, floor(random(0,7)));
    }
    static isMinoMovable(mino,field) {
        let blocks = mino.calcBlocks();
        return blocks.every(b => field.tilesAt(b.x, b.y) === 0);
    }

    GameOver() {
        // console.log(score);
        game.stop();
        background(64);
        fill(255);
        text("GAME OVER",30,250);
    }

    stop() {
        // console.log('seikou');
        this.fc = -1;
    }
    

    proc() {
        // 落下
        // if (this.minoDrop || (this.fc % 20) === 19) {
            if( this.fc !== -1){
            if ((this.fc % 20) === 19) {
            let futureMino = this.mino.copy();
            futureMino.y += 1;
            if(Game.isMinoMovable(futureMino, this.field)) {
                this.mino.y += 1;
                if (this.minoDrop){
                        return this.minoDrop;
                }
        }else{
            // 接地
            if (this.mino.y !== 1){
            for(let b of this.mino.calcBlocks()){
                this.field.putBlock(b.x, b.y);
                this.mino = Game.makeMino();
            }
            }else{
                return this.GameOver();

            }
          }
          // 消去
          let line;
          while((line = this.field.findLineFilled()) !== -1) {
              this.field.cutLine(line);
              score += 100;
              console.log(score);
          }
          this.minoDrop = false;
        }
        //下まで
        if (this.minoDrop){
            let futureMino = this.mino.copy();
            // futureMino.y += while(this.mino.y +1) {this.mino.y++;}
            futureMino.y += 1;
            if(Game.isMinoMovable(futureMino, this.field)) {
                this.mino.y++;
            }
        }
        // カット
        if (this.cut === true){
            game.field.cutLine(19);
            cutpoint += -1;
            return this.cut = false;
        }
        // バニッシュ
        if (this.vanish === true){
            for (let i=0;i<19;i++){
            game.field.cutLine(19);
            }
            vanishpoint += -1;
            return this.vanish = false;
        }
        // チェンジ
        if (this.change === true){
            this.mino = Game.makeMino();
            changepoint += -1;
            return this.change = false;
        }
        // 左右移動
        if (this.minoVx !== 0) {
            let futureMino = this.mino.copy();
            futureMino.x += this.minoVx;
            if(Game.isMinoMovable(futureMino, this.field)) {
                this.mino.x += this.minoVx;
            }
            this.minoVx = 0;
        }
        // 回転
        if (this.minoVr !== 0) {
            let futureMino = this.mino.copy();
            futureMino.rot += this.minoVr;
            if(Game.isMinoMovable(futureMino, this.field)) {
                this.mino.rot += this.minoVr;
            }
            this.minoVr = 0;
        }
        // 描画
        background(64);
        this.mino.draw();
        this.field.draw();

        this.fc++;
    }
}
}


let game;
let stopCM;

function keyPressed() {
    // 左
    if (keyCode === 37) game.minoVx = -1;
    // 右
    if (keyCode === 39) game.minoVx = 1;
    // 上
    if (keyCode === 38) game.minoVr = -1;
    // 下
    if (keyCode === 40) game.minoVr = 1;
    // スペース
    if (keyCode === 13) game.minoDrop = true;
    // F
    if (keyCode === 70) game.cut = cutpoint > 0 ? true : false;
    // D
    if (keyCode === 68) game.change = changepoint > 0 ? true : false;
    // S
    if (keyCode === 83) game.vanish = vanishpoint > 0 ? true : false;
}

// ストップ
// if (stopCM === true) {
//     game.fc = -1;
//     console.log('seikou');
// }


// function setup() {
//     createCanvas(500, 525);
//     background(64);
//     game = new Game();

// }

function setup() {
    createCanvas(500, 525);
    background(64);
    game = new Game();
    // new Promise(function (resolve, reject){
    //     try {
    //         game = new Game();
    //         resolve();
    //     } catch (e) {
    //         reject();
    //     }
        
    // })

}
// start = document.getElementById('start');
// start.addEventListener('click',function(){
//     console.log('seikou')
// });


function draw() {
    game.proc();
    fill(255);
    textSize(40);   
    textAlign(LEFT);
    text("スコア",330,50);
    text(score,355,110);
    text("----------",310,150);
    textSize(30);
    text("アイテム",335,200);
    textSize(15);
    text("バニッシュ[S]",345,250);
    text("残り　　　回",350,290);
    text("チェンジ[D]",350,350);
    text("残り　　　回",350,390);
    text("カット[F]",360,450);
    text("残り　　　回",350,490);
    textSize(40);
    text(vanishpoint,390,295);
    text(changepoint,390,395);
    text(cutpoint,390,495);
}




// 実装したいこと
// 1．テトリスに色を付ける
// 2．アイテムを作る（最下段消去、ストップ、テトチェンジ　など）
// 3．