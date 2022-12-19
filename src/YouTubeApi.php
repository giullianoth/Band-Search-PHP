<?php

namespace Src;

class YouTubeApi extends ApiConnect
{

    public function __construct(string $search)
    {
        $this->apiKey = "AIzaSyDxWH8nbxeYe5S9gs6nHDlydxQqFMjpo_g";
        $this->search = $search;

        parent::__construct("https://youtube.googleapis.com/youtube/v3/search?part=snippet&q={$this->search}&key={$this->apiKey}");
    }

    public function fetch()
    {
        $response = parent::fetch();

        if (!is_object($response)) {
            return ["error" => "Erro inesperado na pesquisa."];
        }

        if (empty($response->items)) {
            return ["error" => "Sua pesquisa por '{$this->search}' não retornou resultados. Tente de novo."];
        }

        $rawData = (array)$response->items;
        $listItems = [];

        for ($i = 0; $i < count($rawData); $i++) {
            $isVideo = strpos($rawData[$i]->id->kind, "video");
            
            if ($isVideo) {
                array_push($listItems, $rawData[$i]);
            }
        }

        return ["listItems" => $listItems];
    }
}