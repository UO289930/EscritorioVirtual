"use strict"
class Api{

    constructor(){
        this.#prepareReproducer();

        const remove = this.removeMusic.bind(this);
        window.addEventListener('error', function (event) {
            remove();
            this.window.alert("Las canciones ya no están disponibles");
            event.preventDefault();
        }, true);
    }

    #prepareReproducer(){
        window.addEventListener("load", () => {
            const drop = document.querySelector('main section[data-element="DnD"]');
            drop.addEventListener("dragover", (e) => {
                e.preventDefault();
                drop.setAttribute("data-state", "dragover");
            });

            drop.addEventListener("dragleave", (e) => {
                drop.setAttribute("data-state", "dragleave");
            });

            drop.addEventListener("drop", (e) => {
                e.preventDefault();
                drop.setAttribute("data-state", "drag-over");
                this.#addFiles(e.dataTransfer.files);
            });

            const input = document.querySelector("input");
            input.addEventListener("change", (e) => {
                this.#addFiles(e.target.files);
            });

            // Añade canciones ya guardadas
            this.#addSongsInStorage();
        });
    }

    #addSongsInStorage(){
        const songs = JSON.parse(localStorage.getItem('playlist')) || [];
        
        songs.forEach(song => {
            this.#addSongToPlaylist(song["name"], song["url"], true);
        });
    }

    removeMusic(){
        localStorage.removeItem("playlist");
        $("main section[data-element='playlist'] li").remove();
    }

    #addFiles(files){
        const audioExtensions = [".mp3", ".wav", ".ogg"];

        for (let i=0; i<files.length; i++) {
            var correct = false;

            for (let j = 0; j < audioExtensions.length; j++) {
                correct = correct || files[i].name.endsWith(audioExtensions[j]);
            }
            if(!correct){
                window.alert("Las únicas extensiones permitidas son: " + audioExtensions);
                return;
            }

            this.#addSongToPlaylist(files[i].name, URL.createObjectURL(files[i]), false);
        }
    }

    #addSongToPlaylist(name, url,  stored){

        const storage = JSON.parse(localStorage.getItem('playlist')) || [];
        const song = { name: name, url: url };
        
        if(!stored){
            for(let i=0; i<storage.length; i++){
                if(storage[i]["name"]===song["name"]){
                    window.alert("La canción " + song["name"] + " ya ha sido añadida previamente");
                    return false;
                }
            }

            storage.push(song);
            localStorage.setItem("playlist", JSON.stringify(storage));
        }

        const audio = document.querySelector("main audio");
        const li = document.createElement("li");

        li.textContent = name;
        li.setAttribute("data-url", url);
        li.addEventListener("click", (e) => {
            audio.setAttribute("src", li.getAttribute("data-url"));

            try{
                audio.play();
            } catch(error){
                localStorage.removeItem("playlist");
                window.alert("Los archivos ya no existen");
            }
        });
        
        $('main section[data-element="playlist"] ul').append(li);

        return true;
        
    }
}

const api = new Api();