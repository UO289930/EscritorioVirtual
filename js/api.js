"use strict"
class Api{

    constructor(){
        this.#prepareDnD();
    }

    #prepareDnD(){
        window.addEventListener("load", () => {
            const drop = document.querySelector('main section[data-element="DnD"]');
            drop.addEventListener("dragover", (e) => {
                e.preventDefault();
                drop.setAttribute("data-state", "dragover")
            });

            drop.addEventListener('dragleave', (e) => {
                drop.setAttribute("data-state", "dragleave")
            });

            drop.addEventListener('drop', (e) => {
                e.preventDefault();
                drop.setAttribute("data-state", "drag-over");
                this.#addFiles(e.dataTransfer.files);
            });

            const input = document.querySelector("input");
            input.addEventListener("change", (e) => {
                this.#addFiles(e.target.files);
            });
        });
    }

    #addFiles(files){
        const audioExtensions = ['.mp3', '.wav', '.ogg'];

        // Necesito querySelector para poder usar .play()
        const audio = document.querySelector("main audio"); 
        var playlist = $('main ul');

        if(!playlist.length){
            playlist = $('<ul></ul>');
            $('main section[data-element="playlist"]').append(playlist);
        }

        for (let i=0; i<files.length; i++) {
            var correct = false;

            for (let j = 0; j < audioExtensions.length; j++) {
                correct = correct || files[i].name.endsWith(audioExtensions[j]);
            }
            if(!correct){
                window.alert("Las únicas extensiones permitidas son: " + audioExtensions);
                return;
            }
            
            const audioUrl = URL.createObjectURL(files[i]);
            var repeated = false;

            $.each($("main section ul li"), (j,li) => {
                if(li.textContent===files[i].name){
                    repeated = true;
                    return;
                }
            } );

            if(repeated){
                continue;
            }

            const li = document.createElement("li");
            li.textContent = files[i].name;
            li.setAttribute("data-url", URL.createObjectURL(files[i]));
            li.addEventListener("click", (e) => {
                audio.setAttribute("src", li.getAttribute("data-url"));
                audio.play();
            });
            
            playlist.append(li);
        }
    }
}

const api = new Api();