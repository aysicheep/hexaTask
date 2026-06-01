# ADR-001 — Repository Pattern

## Statut
Accepté

## Contexte
Les Application Services ont besoin de récupérer et sauvegarder des agrégats.
Sans abstraction, ils dépendraient directement de Doctrine, créant un couplage
fort entre le Domain et une technologie de persistance spécifique.

## Décision
Créer une interface Repository par agrégat root dans le Domain.
Les implémentations Doctrine vivent dans l'Infrastructure.

## Conséquences
+ Domain testable sans base de données (InMemory repositories)
+ Changement d'ORM sans toucher au Domain
- Plus de fichiers à maintenir (une interface + une implémentation par agrégat)