<?php

namespace Alura\BuscadorDeCursos;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Buscador de Cursos
 */
class Buscador
{

    private ClientInterface $httpClient;
    private Crawler $crawler;

    /**
     * Buscador de Cursos
     *
     * @param ClientInterface $httpClient
     * @param Crawler         $crawler
     */
    public function __construct(ClientInterface $httpClient, Crawler $crawler)
    {
        $this->httpClient = $httpClient;
        $this->crawler = $crawler;
    }

    /**
     * Busca cursos atraves de uma URL
     *
     * @param  string $url
     * @return array
     */

    public function buscar(string $url): array
    {
        $answer = $this->httpClient->request('GET', $url);
        $html = $answer->getBody();

        $this->crawler->addHtmlContent($html);
        $elements = $this->crawler->filter('span.card-curso__nome');
        $cursos = [];

        foreach (
            $elements as $element
        ) {
            $cursos[] = $element->textContent;
        }

        return $cursos;
    }
}
