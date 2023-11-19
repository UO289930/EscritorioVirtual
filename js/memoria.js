"use strict";
class Memoria{
    constructor() {
        this.hasFlippedCard = false;
        this.lockBoard = false;
        this.firstCard = null;
        this.secondCard = null;
        this.elements = {
            "elements":[
                {element : "HTML5", source:"https://upload.wikimedia.org/wikipedia/commons/3/38/HTML5_Badge.svg"},
                {element : "HTML5", source:"https://upload.wikimedia.org/wikipedia/commons/3/38/HTML5_Badge.svg"},
                {element : "CSS3", source:"https://upload.wikimedia.org/wikipedia/commons/6/62/CSS3_logo.svg"},
                {element : "CSS3", source:"https://upload.wikimedia.org/wikipedia/commons/6/62/CSS3_logo.svg"},
                {element : "JS", source:"https://upload.wikimedia.org/wikipedia/commons/b/ba/Javascript_badge.svg"},
                {element : "JS", source:"https://upload.wikimedia.org/wikipedia/commons/b/ba/Javascript_badge.svg"},
                {element : "PHP", source:"https://upload.wikimedia.org/wikipedia/commons/2/27/PHP-logo.svg"},
                {element : "PHP", source:"https://upload.wikimedia.org/wikipedia/commons/2/27/PHP-logo.svg"},
                {element : "SVG", source:"https://upload.wikimedia.org/wikipedia/commons/4/4f/SVG_Logo.svg"},
                {element : "SVG", source:"https://upload.wikimedia.org/wikipedia/commons/4/4f/SVG_Logo.svg"},
                {element : "W3C", source:"https://upload.wikimedia.org/wikipedia/commons/5/5e/W3C_icon.svg"},
                {element : "W3C", source:"https://upload.wikimedia.org/wikipedia/commons/5/5e/W3C_icon.svg"}
            ]
        }

        this.shuffleElements();
        this.createElements();
        this.addEventListeners();
    }

    shuffleElements() {
        for (let i = this.elements.elements.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [this.elements.elements[i], this.elements.elements[j]] = [this.elements.elements[j], this.elements.elements[i]];
        }
    }

    unflipCards() {
        this.lockBoard = true; 
    
        setTimeout(() => {
            const cards = document.querySelectorAll('article[data-state="flip"]');
            cards.forEach(card => {
                card.setAttribute("data-state", "init");
            });

            this.resetBoard(); 
        }, 2000);
      }

    resetBoard() {
        this.firstCard = null;
        this.secondCard = null;
        this.hasFlippedCard = false;
        this.lockBoard = false;
    }

    checkForMatch() {
        const source1 = this.elements.elements.find(card => card.element === this.firstCard.getAttribute("data-element")).source;
        const source2 = this.elements.elements.find(card => card.element === this.secondCard.getAttribute("data-element")).source;
        source1 == source2 ? this.disableCards() : this.unflipCards();
    }

    disableCards(){
        const cards = document.querySelectorAll('article[data-state="flip"]');
        cards.forEach(card => {
            card.setAttribute("data-state", "revealed");
        });

        this.resetBoard(); 
    }

    createElements(){

        this.elements.elements.forEach(element => {
            const card = document.createElement("article");
            card.setAttribute("data-element", element.element);
            card.setAttribute("data-state", "init");

            const heading = document.createElement("h3");
            heading.textContent = "Tarjeta de memoria";

            const img = document.createElement("img");
            img.setAttribute("src", element.source);
            img.setAttribute("title", "Tarjeta de juego de memoria");
            img.setAttribute("alt", element.element);

            card.appendChild(heading);
            card.appendChild(img);

            document.querySelector("main>div").appendChild(card);
        });
    }

    addEventListeners(){
        const articles = document.querySelectorAll('main>div>article');
        articles.forEach( card => {
            card.addEventListener('click', this.flipCard.bind(card,this))
        });
    }

    flipCard(memoria){
        if(memoria.lockBoard){return}

        this.setAttribute("data-state", "flip");

        if(memoria.firstCard==null){
            memoria.firstCard = this;
        } else {
            memoria.secondCard = this;
            memoria.checkForMatch();
        }
    }

}