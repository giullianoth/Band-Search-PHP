<?php

namespace Src;

class Validate {

    private $search;
    private $response;

    public function __construct(string $search) {
        // header("Content-Type: application/json");
        $this->search = $search;
    }
    
    public function getResponse(): ?array {
        return $this->response;
    }

    public function search(): void {

        if (empty($this->search)) {
            $this->response = ["error" => "Digite o nome da banda ou artista."];
            return;
        }
        
        $ticketMaster = new TicketMasterApi($this->search);
        $youTube = new YouTubeApi($this->search);

        $response = array_merge(
            ($ticketMaster->fetch() ?? []),
            (empty($ticketMaster->fetch()["error"]) ? $youTube->fetch() : [])
        );
        
        $this->response = $response;
    }

}
