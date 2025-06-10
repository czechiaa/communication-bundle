# CommunicationBundle

Response helper

## License

This package is available under the [MIT license](LICENSE).

## USAGE

config/serializer/app.yaml
```yaml
App\Entity\User:
  attributes:
    id:
      groups: ['Group1', 'Group2']
    username:
      groups: ['Group1']
    firstName:
      groups: ['Group2']
    secondName:
      groups: ['Group2']
```

```php
<?php

declare(strict_types=1);

namespace App\Controller;

use Czechiaa\Bundle\CommunicationBundle\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ApiController extends AbstractController
{
    public function __construct(
        private readonly Response $response
    ) {
    }
    
    #[Route('/first-example', name: 'first_example')]
    public function firstExample(): JsonResponse
    {
        $user = $this->userRepository->findOneById(123);
    
        return $this->response->add($user, Response::context(['groups' => 'Group1']))->send();
        // output: {"id": 123, "username": "user123"}
    }

    #[Route('/second-example', name: 'second_example')]
    public function secondExample(): JsonResponse
    {
        $user = $this->userRepository->findOneById(456);
        $otherUser = $this->userRepository->findOneById(789);
    
        return $this->response
            ->add('user', $user, Response::context(['groups' => 'Group2']))
            ->add('otherUser', $otherUser, Response::context(['groups' => 'Group1']))
            ->add('anyOtherValue', true)
            ->send();
        // output: {"user": {"id": 456, "firstName": "firstName456", "secondName": "secondName456"}, "otherUser": {"id": 789, "username": "user789"}, "anyOtherValue": true}
    }
}

```