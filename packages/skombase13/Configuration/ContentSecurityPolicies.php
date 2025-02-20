<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Security\ContentSecurityPolicy\Directive;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\Mutation;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\MutationCollection;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\MutationMode;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\Scope;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\SourceKeyword;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\SourceScheme;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\UriValue;
use TYPO3\CMS\Core\Type\Map;

return Map::fromEntries([
  Scope::frontend(),
  new MutationCollection(
      # Einstellungen für gesamte Sourcen
      new Mutation(
          MutationMode::Set,
          Directive::DefaultSrc,
          SourceKeyword::self
      ),
      # Einbindung von Google Analytics
      new Mutation(
        MutationMode::Extend,
        Directive::ConnectSrc,
        SourceScheme::data,
        new UriValue('https://www.google-analytics.com')
      ),
      # Einbindung der Bildern von YouTube
      new Mutation(
        MutationMode::Extend,
        Directive::ImgSrc,
        SourceScheme::data,
        new UriValue('*.img.youtube.com')
      ),

      # Einbindung der Schriften von Google Maps
      new Mutation(
        MutationMode::Extend,
        Directive::FontSrc,
        SourceScheme::data,
        new UriValue('https://fonts.gstatic.com')
      ),
   ),
]);
