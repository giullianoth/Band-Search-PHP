<?php

namespace Src;

class TicketMasterApi extends ApiConnect
{

    public function __construct(string $search)
    {
        $this->apiKey = "q2GNlCrgGo6c8uej3Ib4MsbAC2KIr5nG";
        $this->search = $search;

        parent::__construct("https://app.ticketmaster.com/discovery/v2/attractions.json?keyword={$this->search}&apikey={$this->apiKey}");
    }

    public function fetch()
    {

        $response = parent::fetch();

        if (!is_object($response)) {
            return ["error" => "Erro inesperado na pesquisa."];
        }

        if (empty($response->_embedded->attractions)) {
            return ["error" => "Sua pesquisa por '{$this->search}' não retornou resultados. Tente de novo."];
        }

        $rawData = (array)$response->_embedded->attractions;

        $isMusic = false;
        $socialInfo = null;
        $mainTitle = null;

        for ($a = 0; $a < count($rawData); $a++) {

            $classifications = $rawData[$a]->classifications;

            for ($c = 0; $c < count($classifications); $c++) {
                $segment = $classifications[$c]->segment->name;
                if ($segment === "Music") {
                    $isMusic = true;
                    break;
                }
            }

            if ($isMusic) {
                $socialInfo = $rawData[$a]->externalLinks ?? [];
                $mainTitle = $rawData[$a]->name;
                break;
            }
        }

        if (!$isMusic) {
            return ["error" => "Sua pesquisa por '{$this->search}' é inválida. Apenas bandas ou artistas (cantores)."];
        }

        return [
            "socialInfo" => $socialInfo,
            "mainTitle" => $mainTitle
        ];
    }
}
