<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class SearchProductController extends AbstractController
{
    #[Route('/search', name: 'app_product_search', methods: ['GET'])]
    public function searchProducts(Request $request, ProductRepository $productRepository): Response
    {
        // Thay vì sử dụng $request->query->get('q'), bạn nên kiểm tra tham số 'q' có tồn tại hay không
        $query = $request->query->get('q', '');

        $products = $productRepository->findByTitle($query);

        return $this->json([
            'products' => $products,
        ]);
    }
}
